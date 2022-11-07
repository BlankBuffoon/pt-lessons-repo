<?php
    if ( !defined('ABSPATH') ) {
        die;
    }

    wp_nonce_field('wpetmetaboxfields', '_wpet');

    $gl_options = get_post_meta( $post->ID, 'wpet_gl_settings_options', true );
    if ( empty( $gl_options ) ) { settype( $gl_options, "array" ); }

    $gl_gatetime = get_post_meta( $post->ID, 'wpet_gl_settings_datetime', true );
  
    $heading_text = get_post_meta( $post->ID, 'wpet_heading_settings_text', true );
    $heading_fontsize = get_post_meta( $post->ID, 'wpet_heading_settings_fontsize', true );
    
    $timer_fontsize = get_post_meta( $post->ID, 'wpet_tm_settings_fontsize', true );

    $paragraph_text = get_post_meta( $post->ID, 'wpet_pgh_settings_text', true );
    $paragraph_fontsize = get_post_meta( $post->ID, 'wpet_pgh_settings_fontsize', true );

    $button_text = get_post_meta( $post->ID, 'wpet_btn_settings_text', true );
    $button_fontsize = get_post_meta( $post->ID, 'wpet_btn_settings_fontsize', true );
    $button_link = get_post_meta( $post->ID, 'wpet_btn_settings_link', true );
?>
<div class="wpet_metabox" id="wpet_metabox_tabs">
    <ul>
        <li><a class="wpet-vertical-menu-link" href="#general">Основное</a></li>
        <li><a class="wpet-vertical-menu-link" href="#heading">Заголовок</a></li>
        <li><a class="wpet-vertical-menu-link" href="#timer">Таймер</a></li>
        <li><a class="wpet-vertical-menu-link" href="#paragraph">Параграф</a></li>
        <li><a class="wpet-vertical-menu-link" href="#progress_bar">Полоса прогресса</a></li>
        <li><a class="wpet-vertical-menu-link" href="#button">Кнопка</a></li>
    </ul>
    <section class="wpet_metabox_wrapper" id="general">

        <h2>Основные настройки</h2>

        <div class="wpet-grig-section options">
            <p>Опции</p>
            <div>
                <div>
                    <input type="checkbox" id="wpet_gl_settings_options_heading" name="wpet_gl_settings_options[]" value="heading" <?= in_array('heading', $gl_options) ? 'checked="checked"' : '' ?>>
                    <label for="wpet_gl_settings_options_heading">Заголовок</label>
                </div>
                <div>
                    <input type="checkbox" id="wpet_gl_settings_options_timer" name="wpet_gl_settings_options[]" value="timer" <?= in_array('timer', $gl_options) ? 'checked="checked"' : '' ?>>
                    <label for="wpet_gl_settings_options_timer">Таймер</label>
                </div>
                <div>
                    <input type="checkbox" id="wpet_gl_settings_options_paragraph" name="wpet_gl_settings_options[]" value="paragraph" <?= in_array('paragraph', $gl_options) ? 'checked="checked"' : '' ?>>
                    <label for="wpet_gl_settings_options_paragraph">Подзаголовок</label><br>
                </div>
                <div>
                    <input disabled type="checkbox" id="wpet_gl_settings_options_progress_bar" name="wpet_gl_settings_options[]" value="progress_bar" <?= in_array('progress_bar', $gl_options) ? 'checked="checked"' : '' ?>>
                    <label for="wpet_gl_settings_options_progress_bar">Полоса прогресса</label>
                </div>
                <div>
                    <input type="checkbox" id="wpet_gl_settings_options_button" name="wpet_gl_settings_options[]" value="button" <?= in_array('button', $gl_options) ? 'checked="checked"' : '' ?>>
                    <label for="wpet_gl_settings_options_button">Кнопка</label><br>
                </div>
            </div>
        </div>

        <div class="wpet-grig-section date_picker">
            <p>Срок</p>
            <div>
                <input class="datepicker" name="datepicker" placeholder=" <?php
                    if (empty($gl_gatetime)) {
                        echo 'Введите дату и время';
                    } else {
                        echo $gl_gatetime;
                    } ?>">
                <input type="hidden" name="wpet_gl_settings_datetime" id="wpet_gl_settings_datetime" value="<?= $gl_gatetime ?>">
            </div>
        </div>
    </section>

    <section class="wpet_metabox_wrapper" id="heading">

        <h2>Настройки заголовка</h2>

        <div class="wpet-grig-section text">
            <p>Текст заголовка</p>
            <input type="text" name="wpet_heading_settings_text" id="wpet_heading_settings_text" value="<?= $heading_text ?>">
        </div>

        <div class="wpet-grig-section fontsize">
            <p>Размер текста</p>
            <input type="number" name="wpet_heading_settings_fontsize" id="wpet_heading_settings_fontsize" value="<?= $heading_fontsize ?>">
            <label for="wpet_heading_settings_fontsize">px</label>
        </div>

    </section>

    <section class="wpet_metabox_wrapper" id="timer">

        <h2>Настройки таймера</h2>

        <div class="wpet-grig-section fontsize">
            <p>Размер цифр</p>
            <input type="number" name="wpet_tm_settings_fontsize" id="wpet_tm_settings_fontsize" value="<?= $timer_fontsize ?>">
            <label for="wpet_tm_settings_fontsize">px</label>
        </div>

    </section>

    <section class="wpet_metabox_wrapper" id="paragraph">

        <h2>Настройки параграфа</h2>

        <div class="wpet-grig-section text">
            <p>Текст заголовка</p>
            <textarea type="text" name="wpet_pgh_settings_text" id="wpet_pgh_settings_text" value="<?= $paragraph_text ?>" rows="5"></textarea>
        </div>

        <div class="wpet-grig-section fontsize">
            <p>Размер текста</p>
            <input type="number" name="wpet_pgh_settings_fontsize" id="wpet_pgh_settings_fontsize" value="<?= $paragraph_fontsize ?>">
            <label for="wpet_pgh_settings_fontsize">px</label>
        </div>

    </section>

    <section class="wpet_metabox_wrapper" id="progress_bar">

        <h2>Настройки полосы прогресса</h2>

        <?php include('wpet-currently-unavalible-layout.php') ?>

    </section>
    
    <section class="wpet_metabox_wrapper" id="button">

        <h2>Настройки кнопки</h2>

        <div class="wpet-grig-section text">
            <p>Текст кнопки</p>
            <input type="text" name="wpet_btn_settings_text" id="wpet_btn_settings_text" value="<?= $button_text ?>">
        </div>

        <div class="wpet-grig-section fontsize">
            <p>Размер текста</p>
            <input type="number" name="wpet_btn_settings_fontsize" id="wpet_btn_settings_fontsize" value="<?= $button_fontsize ?>">
            <label for="wpet_btn_settings_fontsize">px</label>
        </div>

        <div class="wpet-grig-section link">
            <p>Ссылка</p>
            <input type="text" name="wpet_btn_settings_link" id="wpet_btn_settings_link" value="<?= $button_link ?>">
        </div>

    </section>
</div>
