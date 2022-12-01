<?php
$urlTema = get_template_directory_uri();
?>
<div id="wrapper" dir="ltr" style="background-color: #fbfbfb; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<div id="template_header_image">
					<p style="margin-top: 0;">						
					<?php 
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );

					if($custom_logo_url == ""){
						echo '<img src="'.$urlTema.'/img/logo-enuo_mail.png" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" alt="ENUO" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; margin-left: 0; margin-right: 0;">';
					}else{
						echo '<img src="' . esc_url( $custom_logo_url ) . '" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" alt="ENUO" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; margin-left: 0; margin-right: 0;">';
					}
					?>
					</p>
				</div>
				<table id="template_container" style="background-color: #ffffff; border: 1px solid #e2e2e2; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;" width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
						<td valign="top" align="center">
							<!-- Header -->
							<table id="template_header" style="background-color: #e64a77; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;" width="600" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									<td id="header_wrapper" style="padding: 36px 48px; display: block;">
										<h1 style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #89cd6d; color: #ffffff;"><?php echo $titulo;?></h1>
									</td>
								</tr>
							</tbody></table>
							<!-- End Header -->
						</td>
					</tr>
					<tr>
						<td valign="top" align="center">
							<!-- Body -->
							<table id="template_body" width="600" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									<td id="body_content" style="background-color: #ffffff;" valign="top">
										<!-- Content -->
										<table width="100%" cellspacing="0" cellpadding="20" border="0">
											<tbody><tr>
												<td style="padding: 48px 48px 32px;" valign="top">
													<div id="body_content_inner" style="color: #5c5c5c; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
																								