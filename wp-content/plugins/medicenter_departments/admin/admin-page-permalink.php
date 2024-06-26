<div class="wrap permalink-settings-section">
	<h2><?php _e("Permalink settings", "medicenter_departments"); ?></h2>
</div>
<?php
if(!empty($message))
{
?>
<div class="<?php echo ($message!="" ? "updated" : "error"); ?> settings-error"> 
	<p>
		<?php echo $message; ?>
	</p>
</div>
<?php
}
?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="permalink-config-form">
	<div class="permalink-form-table-container">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="calculator_skin">
							<?php _e("Slug (permalink)", "medicenter_departments"); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text input-full-width" value="<?php echo esc_attr($departments_permalink["slug"]); ?>" id="slug" name="slug">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="calculator_skin">
							<?php _e("Department label singular", "medicenter_departments"); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text input-full-width" value="<?php echo esc_attr($departments_permalink["label_singular"]); ?>" id="label_singular" name="label_singular">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="calculator_skin">
							<?php _e("Department label plural", "medicenter_departments"); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text input-full-width" value="<?php echo esc_attr($departments_permalink["label_plural"]); ?>" id="label_plural" name="label_plural">
					</td>
				</tr>
				<tr valign="top" class="no-border">
					<th colspan="2">
						<input type="submit" value="<?php esc_attr_e("Save Options", 'medicenter_departments'); ?>" class="button-primary" name="submit">
						<input type="hidden" name="action" value="save_departments_permalink">
					</th>
				</tr>
			</tbody>
		</table>
	</div>
</form>