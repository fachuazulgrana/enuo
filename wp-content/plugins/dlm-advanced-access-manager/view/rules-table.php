<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="dlm-aam-rules">
	<input type="hidden" name="dlm_aam_nonce" value="<?php echo wp_create_nonce( Dlm_Aam_Constants::NONCE_MB ); ?>" />
	<p class="toolbar">
		<a href="#" class="button plus add_rule">Add Rule</a>
	</p>

	<div class="dlm-aam-rules-table-wrapper">
		<table cellspacing="0" cellpadding="0" border="0" class="dlm-aam-rules-table" data-id="<?php echo $download_id; ?>" data-nonce="<?php echo wp_create_nonce( Dlm_Aam_Constants::NONCE_AJAX ); ?>">
			<thead>
			<tr>
				<th class="dlm-aam-group">Group</th>
				<th class="dlm-aam-group-value">Group Value</th>
				<th class="dlm-aam-can-download">Can Download?</th>
				<th class="dlm-aam-restriction">Restriction</th>
				<th class="dlm-aam-restriction-sub">Restriction Value</th>
				<th class="dlm-aam-actions">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>