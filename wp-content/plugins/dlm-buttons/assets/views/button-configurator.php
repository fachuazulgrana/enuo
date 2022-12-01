<?php
/** @var DLM_Buttons_Config $config */

?>
<div class="wrap dlm-buttons">
    <h1>Buttons</h1>
    <div class="dlm-buttons-wrap">
        <div class="dlm-buttons-config" data-template_name="<?php echo $config->get_template_name(); ?>">
            <p class="dlm-buttons-full-width">
                <a class="button" href="<?php echo admin_url( 'edit.php?post_type=dlm_download&page=dlm-buttons' ); ?>"><?php _e( 'Back to overview', 'dlm-buttons' ); ?></a>
            </p>
            <fieldset>
                <legend><?php _e( 'Template Data', 'dlm-buttons' ); ?></legend>
                <p class="dlm-buttons-full-width">
                    <strong><?php _e( "Template Name (can't be changed)", 'dlm-buttons' ); ?></strong>
                    <input type="text" name="template_name" value="<?php echo $config->get_template_name(); ?>"
                           disabled="true"/>
                </p>
            </fieldset>
            <fieldset>
                <legend><?php _e( 'Background', 'dlm-buttons' ); ?></legend>
                <p>
                    <strong for=""><?php _e( 'Background Color 1', 'dlm-buttons' ); ?></strong>
                    <input type="text" name="bg_color_1" value="#<?php echo $config->get_bg_color_1(); ?>"
                           class="dlm-buttons-config-field dlm-buttons-color-picker"/>
                </p>
                <p>
                    <strong for=""><?php _e( 'Background Color 2', 'dlm-buttons' ); ?></strong>
                    <input type="text" name="bg_color_2" value="#<?php echo $config->get_bg_color_2(); ?>"
                           class="dlm-buttons-config-field dlm-buttons-color-picker"/>
                </p>
            </fieldset>
            <fieldset>
                <legend><?php _e( 'Border', 'dlm-buttons' ); ?></legend>
                <p>
                    <strong for=""><?php _e( 'Border Thickness', 'dlm-buttons' ); ?></strong>
                    <input type="number" name="border_thickness" value="<?php echo $config->get_border_thickness(); ?>"
                           class="dlm-buttons-config-field"/>
                </p>
                <p>
                    <strong for=""><?php _e( 'Border Color', 'dlm-buttons' ); ?></strong>
                    <input type="text" name="border_color" value="#<?php echo $config->get_border_color(); ?>"
                           class="dlm-buttons-config-field dlm-buttons-color-picker"/>
                </p>
                <p>
                    <strong for=""><?php _e( 'Border Radius', 'dlm-buttons' ); ?></strong>
                    <input type="number" name="border_radius" value="<?php echo $config->get_border_radius(); ?>"
                           class="dlm-buttons-config-field"/>
                </p>
            </fieldset>
            <fieldset>
                <legend><?php _e( 'Font', 'dlm-buttons' ); ?></legend>
                <p>
                    <strong for=""><?php _e( 'Font', 'dlm-buttons' ); ?></strong>
                    <select name="font" class="dlm-buttons-config-field">
						<?php
						$fonts = DLM_Buttons_Fonts::get_available_fonts();
						foreach ( $fonts as $font ) {
							echo '<option value="' . $font . '" style="font-family: ' . $font . ';" ' . selected( $config->get_font(), $font ) . '>' . $font . '</option>' . PHP_EOL;
						}
						?>
                    </select>
                </p>
                <p>
                    <strong for=""><?php _e( 'Font Color', 'dlm-buttons' ); ?></strong>
                    <input type="text" name="font_color" value="#<?php echo $config->get_font_color(); ?>"
                           class="dlm-buttons-config-field dlm-buttons-color-picker"/>
                </p>
                <p>
                    <strong for=""><?php _e( 'Font Size', 'dlm-buttons' ); ?></strong>
                    <input type="number" name="font_size" value="<?php echo $config->get_font_size(); ?>"
                           class="dlm-buttons-config-field"/>
                </p>
            </fieldset>
            <fieldset>
                <legend><?php _e( 'Text', 'dlm-buttons' ); ?></legend>
                <p class="dlm-buttons-full-width">
                    <strong for=""><?php _e( 'Text', 'dlm-buttons' ); ?></strong>
                    <textarea name="text"
                              class="dlm-buttons-config-field"><?php echo str_ireplace( '<br />', PHP_EOL, $config->get_text() ); ?></textarea>
                    <code><?php printf( __( 'Available variables are %s', 'dlm-buttons' ), '%' . implode( '%,%', DLM_Buttons_Text::get_available_variables() ) . '%' ); ?></code>
                    <code><?php printf( __( 'Allowed HTML tags are %s', 'dlm-buttons' ), esc_html( '<' . implode( '><', DLM_Buttons_Text::get_allowed_html_tags() ) . '>' ) ); ?></code>
                </p>
                <p>
                    <strong for=""><?php _e( 'Text Shadow', 'dlm-buttons' ); ?></strong>
                    <input type="checkbox" name="text_shadow"
                           id="text_shadow" <?php checked( 1, $config->get_text_shadow() ); ?>
                           class="dlm-buttons-config-field"/>
                    <label for="text_shadow"> <?php _e( 'Enable', 'dlm-buttons' ); ?></label>
                </p>
            </fieldset>
            <p class="dlm-buttons-full-width">
                <a class="button button-primary button-large"
                   id="dlm-buttons-save"><?php _e( 'Save Button', 'dlm-buttons' ); ?></a>
            </p>

        </div>
        <div class="dlm-buttons-preview">
            <fieldset>
                <legend><?php _e( 'Button Preview', 'dlm-buttons' ); ?></legend>
                <iframe id="dlm-buttons-preview-frame" src="" frameborder="0" width="400" height="300"
                        scrolling="no"></iframe>
            </fieldset>
        </div>
    </div>
</div>