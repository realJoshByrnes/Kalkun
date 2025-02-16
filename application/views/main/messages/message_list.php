<?php
$this->load->helper('kalkun');
if ($messages->num_rows() == 0)
{
	$no_message_container['start'] = '<p class="no_content"><span class="ui-icon ui-icon-alert" style="float:left;"></span><i>';
	$no_message_container['end'] = '</i></p>';

	if ($folder == 'my_folder')
	{
		if ($this->uri->segment(4) == '5')
		{
			echo $no_message_container['start'].tr('There is no messages in your trash').$no_message_container['end'];
		}
		else
		{
			echo $no_message_container['start'].tr('There is no message in this folder').$no_message_container['end'];
		}
	}
	else
	{
		$folder_type = '';
		switch ($type)
		{
			case 'inbox':
				$folder_type = tr('Inbox');
				break;
			case 'outbox':
				$folder_type = tr('Outbox');
				break;
			case 'sentitems':
				$folder_type = tr('Sent items');
				break;
		}
		echo $no_message_container['start'].tr('There is no message in your {0}.', NULL, $folder_type).$no_message_container['end'];
	}
}
else
{
	// loop - begin
	foreach ($messages->result() as $tmp):

	// initialization
	// $type = $this->uri->segment(3);
	if ($type == 'inbox')
	{
		$qry = $this->Phonebook_model->get_phonebook(array('option' => 'bynumber', 'number' => $tmp->SenderNumber));
		if ($qry->num_rows() !== 0)
		{
			$senderName = $qry->row('Name');
		}
		else
		{
			$senderName = phone_format_human($tmp->SenderNumber);
		}
		$number = $tmp->SenderNumber;

		$message_date = $tmp->ReceivingDateTime;
		$arrow = 'arrow_left';
	}
	else
	{
		$qry = $this->Phonebook_model->get_phonebook(array('option' => 'bynumber', 'number' => $tmp->DestinationNumber));
		if ($qry->num_rows() !== 0)
		{
			$senderName = $qry->row('Name');
		}
		else
		{
			$senderName = phone_format_human($tmp->DestinationNumber);
		}
		$number = $tmp->DestinationNumber;

		$message_date = $tmp->SendingDateTime;
		if ($type == 'outbox')
		{
			$arrow = 'circle';
		}
		else
		{
			$arrow = 'arrow_right';
		}
	}

	// count string for message preview
	$char_per_line = 100 - strlen(kalkun_nice_date($message_date)) - strlen($senderName);

	if ($this->config->item('conversation_grouping'))
	{
		$checkbox_value = $number;
	}
	else
	{
		$checkbox_value = $tmp->ID;
	} ?>

<div title="<?php echo $tmp->TextDecoded?>" class="messagelist <?php  if ($type == 'inbox' && $tmp->readed == 'false')
	{
		echo 'unreaded';
	} ?>">
	<div class="message_container">
		<div class="message_header" style="color: #444; height: 20px; overflow: hidden">
			<input type="checkbox" id="<?php echo $checkbox_value; ?>" class="select_conversation nicecheckbox" value="<?php echo $checkbox_value; ?>" style="border: none;" />
			<span class="message_toggle" style="cursor: pointer;" onclick="document.location.href='<?php echo site_url(); ?>/messages/conversation/<?php echo $folder; ?>/<?php echo $type; ?>/<?php echo rawurlencode($number); ?>/<?php if ($folder == 'my_folder')
	{
		echo $this->uri->segment(4);
	} ?>'">
				<span <?php  if ($type == 'inbox' && $tmp->readed == 'false')
	{
		echo 'style="font-weight: bold"';
	} ?>><?php echo kalkun_nice_date($message_date); ?>&nbsp;&nbsp;<img src="<?php echo $this->config->item('img_path').$arrow; ?>.gif" />
					&nbsp;&nbsp;<?php echo $senderName; ?>
					<?php
			if ($folder == 'folder'):
			echo '('.$this->Message_model->get_messages(array('type' => $type, 'number' => $number, 'uid' => $this->session->userdata('id_user')))->num_rows().')';
	else:
			echo '('.$this->Message_model->get_messages(array('type' => $type, 'number' => $number, 'id_folder' => $this->uri->segment(4), 'uid' => $this->session->userdata('id_user')))->num_rows().')';
	endif; ?>
				</span>
				<span class="message_preview" <?php  if ($type == 'inbox' && $tmp->readed == 'false')
	{
		echo 'style="font-weight: bold"';
	} ?>>-&nbsp;<?php echo message_preview($tmp->TextDecoded, $char_per_line); ?></span>
			</span>
		</div>
	</div>
</div>

<?php
		endforeach;
}
?>
