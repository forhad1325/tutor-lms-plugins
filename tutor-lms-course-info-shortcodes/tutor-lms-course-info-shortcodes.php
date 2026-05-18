<?php
/*##########################################
Tutor LMS Customization / Functions / Shortcodes
##########################################*/

// Add archive title to Tutor LMS Archive Template
function custom_tutor_course_archive_title() {
    $archive_title = get_the_archive_title();
    echo '<h1 class="custom-archive-title">' . str_replace('Category: ', '', $archive_title) . '</h1>';
}
add_action('tutor_course/archive/before_loop', 'custom_tutor_course_archive_title', 99);

// [course_summary] shortcode
function display_tutor_course_summary() {
    ob_start();
    echo get_the_excerpt();
    return ob_get_clean();
}
add_shortcode('course_summary', 'display_tutor_course_summary');

// [course_instructors] shortcode
function display_tutor_course_instructors() {
    $instructors = tutor_utils()->get_instructors_by_course();
    ob_start();
    if ($instructors) : ?>
    <div class="instructors-list">
        <div class="instructor-photos">
            <?php foreach ($instructors as $instructor) : ?>
                <?php if ($instructor->tutor_profile_photo) : ?>
                    <a href="<?php echo tutor_utils()->profile_url($instructor->ID, true); ?>" target="_blank">
                        <img src="<?php echo wp_get_attachment_url($instructor->tutor_profile_photo); ?>" alt="<?php echo $instructor->display_name; ?>" class="instructor-image">
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif;
    return ob_get_clean();
}
add_shortcode('course_instructors', 'display_tutor_course_instructors');

// [course_last_update] shortcode
function display_tutor_course_last_update() {
    ob_start();
    echo '<div class="course-last-update"><span class="date">' . esc_html(get_the_modified_date()) . '</span></div>';
    return ob_get_clean();
}
add_shortcode('course_last_update', 'display_tutor_course_last_update');

// [course_duration] shortcode
function display_tutor_course_duration() {
    $duration = get_tutor_course_duration_context(0, true) ?: 0;
    ob_start();
    echo '<div class="course-duration"><span class="duration">' . $duration . '</span></div>';
    return ob_get_clean();
}
add_shortcode('course_duration', 'display_tutor_course_duration');

// [course_enrollment] shortcode
function display_tutor_course_enrollment() {
    $total = (int) tutils()->count_enrolled_users_by_course();
    ob_start();
    echo '<div class="course-total-enrolled"><span class="number">' . $total . '</span></div>';
    return ob_get_clean();
}
add_shortcode('course_enrollment', 'display_tutor_course_enrollment');
