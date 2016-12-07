<?php if (!defined('ABSPATH')) exit;
global $options;
$general = $options['general'];
?>
<div class="swp-print">
    <form id="swp-form" action="<?php echo admin_url('admin-ajax.php') ?>" method="post">
        <input type="hidden" name="action" value="swp_print_button_update_options"/>

        <div class="tabs">
            <div class="tabs-header">
                <label id="tab-1" class="tab-label active" data-target="swp-tab-1">General</label>
                <label id="tab-2" class="tab-label" data-target="swp-tab-2">Header & Footer</label>
                <label id="tab-3" class="tab-label" data-target="swp-tab-3">Print Permissions</label>
                <label id="tab-4" class="tab-label" data-target="swp-tab-4">About</label>
            </div>

            <div id="swp-tab-1" class="tab active">
                <div class="content">
                    <section>
                        <h2>Print Settings</h2>

                        <div class="half_section">
                            <h4>Plugin enabled on this Post Types</h4>

                            <?php
                            $ptypes = get_post_types('', 'names');
                            $post_types = array_diff($ptypes, array('attachment', 'revision', 'nav_menu_item'));

                            $allowed_post_types = $general['enabled_post_types'];

                            foreach ($post_types as $post_type) {
                                if (in_array($post_type, $allowed_post_types))
                                    echo '<label class="inline-lbl unselectable">' .
                                        '<input type="checkbox" class="custom-switch" checked="checked" name="swp_enabled_post_types[' . $post_type . ']" value="1"/>' . ucfirst($post_type) . '</label>';
                                else
                                    echo '<label class="inline-lbl unselectable">' .
                                        '<input type="checkbox" class="custom-switch" name="swp_enabled_post_types[' . $post_type . ']" value="1"/>' . ucfirst($post_type) . '</label>';
                            }
                            ?>
                        </div>
                        <div class="half_section right_section">
                            <h4>Other Settings</h4>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_post_date'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_post_date" value="1"/> Print Post Date</label>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_modified_date'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_modified_date" value="1"/> Print Post Modified Date</label>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_post_title'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_post_title" value="1"/> Print Post Title</label>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_post_images'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_post_images" value="1"/> Print Images</label>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_header'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_header" value="1"/> Print Custom Header</label>
                            <label class="inline-lbl unselectable"><input
                                    type="checkbox" class="custom-switch" <?php echo $general['print_footer'] == true ? 'checked="checked"' : '' ?>
                                    name="swp_print_footer" value="1"/> Print Post Footer</label>
                        </div>
                        <div class="clearfix"></div>
                        <br/>

                    </section>

                    <section>
                        <h2>Print Buttons Settings</h2>

                        <div class="half_section">
                            <label><strong>Icon Settings:</strong></label>
                            <ul>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon1' ? 'checked="checked"' : '' ?>
                                               value="icon1"/>
                                        <img src="<?php echo SWPPRINTURL . 'assets/icons/icon1.png' ?>" alt=""/>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon2' ? 'checked="checked"' : '' ?>
                                               value="icon2"/>
                                        <img src="<?php echo SWPPRINTURL . 'assets/icons/icon2.png' ?>" alt=""/>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon3' ? 'checked="checked"' : '' ?>
                                               value="icon3"/>
                                        <img src="<?php echo SWPPRINTURL . 'assets/icons/icon3.png' ?>" alt=""/>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon4' ? 'checked="checked"' : '' ?>
                                               value="icon4"/>
                                        <img src="<?php echo SWPPRINTURL . 'assets/icons/icon4.png' ?>" alt=""/>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon5' ? 'checked="checked"' : '' ?>
                                               value="icon5"/>
                                        <img src="<?php echo SWPPRINTURL . 'assets/icons/icon5.png' ?>" alt=""/>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio"
                                               name="swp_button_icon" <?php echo $general['button_icon'] == 'icon6' ? 'checked="checked"' : '' ?>
                                               value="icon6"/> Text Button
                                    </label>
                                    <ul>
                                        <li class="icon_text">
                                            <label>Custom Text</label> <input type="text" name="swp_button_text"
                                                                              value="<?php echo $general['button_text'] ?>"/>
                                        </li>
                                        <li class="icon_text">
                                            <label>Text Size</label> <input type="text" name="swp_button_text_size"
                                                                            value="<?php echo $general['button_text_size'] ?>"/>
                                        </li>
                                        <li class="icon_text">
                                            <label style="margin-bottom: 5px; display: block; clear: both;">Text
                                                Weight</label>
                                            <label class="unselectable"><input type="checkbox"
                                                                               name="swp_button_bold" <?php echo $general['button_bold'] == true ? 'checked="checked"' : '' ?>/>Bold
                                                Text</label>
                                        </li>
                                        <li class="icon_text">
                                            <label>Color</label> <input id="swp-print-color" name="swp_button_bg_color"
                                                                        value="<?php echo $general['button_bg_color'] ?>"
                                                                        type="text"/>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="half_section right_section">
                            <div class="row_setting">
                                <label><strong>Button Position:</strong></label>
                                <label class="unselectable inline-lbl"><input type="radio"
                                                                              name="swp_button_position" <?php echo $general['button_position'] == 'top' ? 'checked="checked"' : '' ?>
                                                                              value="top"/> Top</label>
                                <label class="unselectable inline-lbl"><input type="radio"
                                                                              name="swp_button_position" <?php echo $general['button_position'] == 'bottom' ? 'checked="checked"' : '' ?>
                                                                              value="bottom"/> Bottom</label>
                            </div>
                            <div class="row_setting">
                                <label><strong>Page Margin:</strong></label>
                                <br/>
                                <label style="display: block">
                                    <span style="min-width: 70px; display: inline-block;">Top </span>
                                    <input style="width: 50px" type="text" name="swp_page_margin_top"
                                           value="<?php echo $general['page_margin_top']; ?>"/>
                                </label>
                                <label style="display: block">
                                    <span style="min-width: 70px; display: inline-block;">Bottom </span>
                                    <input style="width: 50px" type="text" name="swp_page_margin_bottom"
                                           value="<?php echo $general['page_margin_bottom']; ?>"/>
                                </label>
                                <label style="display: block">
                                    <span style="min-width: 70px; display: inline-block;">Right </span>
                                    <input style="width: 50px" type="text" name="swp_page_margin_right"
                                           value="<?php echo $general['page_margin_right']; ?>"/>
                                </label>
                                <label style="display: block">
                                    <span style="min-width: 70px; display: inline-block;">Left </span>
                                    <input style="width: 50px" type="text" name="swp_page_margin_left"
                                           value="<?php echo $general['page_margin_left']; ?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </section>
                </div>
            </div>

            <div id="swp-tab-2" class="tab">
                <div class="content">
                    <h2>Header & Footer</h2>

                    <div class="form-field _msa_heading ">
                        <h5>Content Before Post Start</h5>
                        <?php wp_editor(stripcslashes($options['header_html']), 'swp_print_header_html', array(
                            'editor_height' => 180
                        )) ?>
                    </div>

                    <div class="form-field _msa_heading ">
                        <h5>Content After Post End</h5>
                        <?php wp_editor(stripcslashes($options['footer_html']), 'swp_print_footer_html', array(
                            'editor_height' => 180
                        )) ?>
                    </div>
                </div>
            </div>

            <div id="swp-tab-3" class="tab">
                <div class="content">
                    <h4>Who should see the print button</h4>
                    <?php
                    global $wp_roles;
                    $permissions = $options['print_permissions'];
                    foreach ($wp_roles->roles as $k => $v) {
                        if (in_array($k, $permissions)) {
                            ?>
                            <label class="swp-permissions-label">
                                <input type="checkbox" class="custom-switch" name="swp_checked_roles[<?php echo $k ?>]" checked="checked"
                                       value="1"/>
                                <?php echo $v['name'] ?>
                            </label>
                        <?php
                        } else {
                            ?>
                            <label class="swp-permissions-label">
                                <input type="checkbox" class="custom-switch" name="swp_checked_roles[<?php echo $k ?>]" value="1"/>
                                <?php echo $v['name'] ?>
                            </label>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div id="swp-tab-4" class="tab">
                <div class="content">
                    <h3>About</h3>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also
                        the
                        leap into electronic typesetting, remaining essentially unchanged. It was popularised in the
                        1960s
                        with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                        desktop
                        publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also
                        the
                        leap into electronic typesetting, remaining essentially unchanged. It was popularised in the
                        1960s
                        with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                        desktop
                        publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also
                        the
                        leap into electronic typesetting, remaining essentially unchanged. It was popularised in the
                        1960s
                        with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                        desktop
                        publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    <p>
                </div>
            </div>
            <p>
                <input type="submit" name="swp_submit_button" id="submit" class="button button-primary"
                       disabled="disabled" value="Save Changes">
            </p>
        </div>
    </form>
</div>