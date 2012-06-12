<?php

class block_student_gradeviewer extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_student_gradeviewer');
    }

    function applicable_formats() {
        return array('site' => true, 'my' => true, 'course' => false);
    }

    function get_content() {
        global $CFG, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $_s = function($key, $a = null) {
            return get_string($key, 'block_student_gradeviewer', $a);
        };

        $content = new stdClass;
        $content->items = array();
        $content->icons = array();
        $content->footer = '';

        $context = get_context_instance(CONTEXT_SYSTEM);

        $mentor = (
            has_capability('block/student_gradeviewer:viewgrades', $context) or
            has_capability('block/student_gradeviewer:sportsgrades', $context)
        );

        $admin = (
            has_capability('block/student_gradeviewer:academicadmin', $context) or
            has_capability('block/student_gradeviewer:sportsadmin', $context)
        );

        if ($mentor) {
            $url = new moodle_url('/blocks/student_gradeviewer/viewgrades.php');
            $content->items[] = html_writer::link($url, $_s('viewgrades'));
        }

        if ($admin) {
            $url = new moodle_url('/blocks/student_gradeviewer/admin.php');
            $content->items[] = html_writer::link($url, $_s('admin'));
        }

        $this->content = $content;

        return $this->content;
    }
}
