<?php
/**
 * Prints a particular instance of pasanlive_enrolment_module
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_pasanlive_enrolment
 */
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.php');
require_once (dirname ( __FILE__ ) . '/lib.php');

if (!isset($SESSION->addedCourses)) {
	$SESSION->addedCourses = array();
}

global $CFG;
global $COURSE, $USER;
global $idNo;
global $DB;

$context = context_course::instance($COURSE->id);

$isadmin = false;
$isteacher = false;

$roles = get_user_roles($context, $USER->id);
$admins = get_admins();

foreach($admins as $admin) {
	if ($USER->id == $admin->id) {
		$isadmin = true;
		break;
	}
}

if (user_has_role_assignment($USER->id, 3))
	$isteacher = true;

$id = optional_param ( 'id', 0, PARAM_INT ); // course_module ID, or
$n = optional_param ( 'n', 0, PARAM_INT ); // pasanlive_enrolment_module instance ID - it should be named as the first character of the module

if ($id) {
	$cm = get_coursemodule_from_id ( 'virtualclass', $id, 0, false, MUST_EXIST );
	$course = $DB->get_record ( 'course', array (
			'id' => $cm->course
	), '*', MUST_EXIST );
	$pasanlivevirtualclass = $DB->get_record ( 'virtualclass', array (
			'id' => $cm->instance
	), '*', MUST_EXIST );
} elseif ($n) {
	$pasanlivevirtualclass = $DB->get_record ( 'virtualclass', array (
			'id' => $n
	), '*', MUST_EXIST );
	$course = $DB->get_record ( 'course', array (
			'id' => $pasanlivevirtualclass->course
	), '*', MUST_EXIST );
	$cm = get_coursemodule_from_instance ( 'virtualclass', $pasanlivevirtualclass->id, $course->id, false, MUST_EXIST );
} else {
	print_error ( 'You must specify a course_module ID or an instance ID' );
}

require_login ( $course, true, $cm );
$context = context_module::instance ( $cm->id );

add_to_log ( $course->id, 'pasanlive_virtualclass', 'view', "view.php?id={$cm->id}", $pasanlivevirtualclass->id, $cm->id );

$idNo = $cm->id;
// / Print the page header
$PAGE->set_url ( '/mod/virtualclass/view.php', array (
		'id' => $cm->id
));
$PAGE->set_title ( format_string ( $pasanlivevirtualclass->name ) );
$PAGE->set_heading ( format_string ( $course->fullname ) );
$PAGE->set_context ( $context );

// Output starts here
echo $OUTPUT->header ();

$list = get_courses ();

// Replace the following lines with you own code
echo $OUTPUT->heading ( 'Virtual Class' );

if ($isadmin) {
	echo "Hi Admin";
} else if ($isteacher) {
	echo 'You are a teacher';
	?>
<p>Welcome to Virtual Classroom. Your are a teacher. So you can initiate
	a video conference with you students.</p>
<p>You can use your current google+ account to use hangout and you can
	invite your studetns using their G+ id or email address.</p>
<script
	src="https://apis.google.com/js/platform.js" async defer></script>
<g:hangout render="createhangout"
	initial_apps="[{ app_id : '184219133185', start_data : 'dQw4w9WgXcQ', 'app_type': 'ROOM_APP' }]" widget_size="72">
</g:hangout>
<p>Also you can initiate a broadcast sesstion using Hangout On Air.
	Please click below button to start Hangout On Air</p>
<g:hangout render="createhangout"
	initial_apps="[{ app_id : '184219133185', start_data : 'dQw4w9WgXcQ', 'app_type': 'ROOM_APP' }]" hangout_type="onair" widget_size="72">
</g:hangout>
	
	


<?php 
} else {
	?>
<p>Welcome to Virtual Classroom. Your are a student. So you can initiate
	a video conference with you colleagues.</p>
<p>You can use your current google+ account to use hangout and you can
	invite your colleague using their G+ id or email address.</p>
<script
	src="https://apis.google.com/js/platform.js" async defer></script>
<g:hangout render="createhangout"
	initial_apps="[{ app_id : '184219133185', start_data : 'dQw4w9WgXcQ', 'app_type': 'ROOM_APP' }]">
</g:hangout>

<?php 
}




// Finish the page

// echo '>>>>>';
echo $OUTPUT->footer ();
