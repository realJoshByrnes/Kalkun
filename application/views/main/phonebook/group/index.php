<?php $this->load->view('js_init/phonebook/js_group');?>
<!-- Delete Group Confirmation -->
<div class="dialog" id="confirm_delete_group_dialog" title="<?php echo lang('tni_group_del_title');?>">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
	<?php echo lang('tni_group_delete');?></p>
</div>

<div id="contact_container" class="hidden"></div>

<!-- Add/Edit Group dialog -->
<div id="addgroupdialog" title="Add Group"  class="dialog">
	<form class="addgroupform" method="post" action="<?php echo  site_url();?>/phonebook/add_phonebook_group">
		<input type="hidden" name="pbkgroup_id_user" value="<?php echo $this->session->userdata('id_user');?>" />
		<input type="hidden" name="pbkgroup_id" class="pbkgroup_id" value="" />
		<label for="name"><?php echo lang('tni_group_name');?></label>
		<input type="text" name="group_name" id="group_name" class="text ui-widget-content ui-corner-all" />
	</form>
</div>
	
<div id="window_container">
<div id="window_title">
	<div id="window_title_left"><?php echo lang('tni_groups');?></div>
	<div id="window_title_right">
	<a href="#" id="addpbkgroup" class="addpbkgroup nicebutton">&#43; <?php echo lang('tni_group_add');?></a>	
	<a href="<?php echo site_url('phonebook');?>" class="nicebutton">&#43; <?php echo lang('tni_groups_edit_contacts');?></a>
	</div>
</div>

<div id="window_content">
	<?php $this->load->view("main/phonebook/group/navigation");?>
	<div id="pbk_list"><?php $this->load->view('main/phonebook/group/pbk_list');?></div>
	<?php $this->load->view("main/phonebook/group/navigation");?>
</div>
</div>