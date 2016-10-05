<?php
/**
 * Template for displaying buttons of a quiz
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course = LP()->global['course'];
$quiz   = LP()->global['course-item'];
$user   = learn_press_get_current_user();
if ( !$quiz ) {
	return;
}

if ( $user->has( 'finished-course', $course->id ) ) {
	return;
}

$status   = $user->get_quiz_status( $quiz->id );
$question = $quiz->get_current_question();
?>
<div class="quiz-buttons">

	<?php if ( $user->has( 'quiz-status', array( 'started' ), $quiz->id ) ): ?>
		<button class="button-prev-question" data-block-content="yes"><?php esc_html_e( 'Previous', 'learnpress' ); ?></button>
		<button class="button-next-question" data-block-content="yes"><?php esc_html_e( 'Next', 'learnpress' ); ?></button>
		<?php if ( !$user->has_checked_answer( $question->id, $quiz->id, $course->id ) ): ?>
			<button
				class="button-check-answer"
				data-id="<?php esc_attr_e( $quiz->id ); ?>"
				data-block-content="yes"
				data-security="<?php esc_attr_e( wp_create_nonce( 'check-question-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
				<?php esc_html_e( 'Check', 'learnpress' ); ?>
			</button>
			<button class="button-hint" data-security="<?php esc_attr_e( wp_create_nonce( 'get-question-hint-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>"><?php esc_html_e( 'Hint', 'learnpress' ); ?></button>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( $user->has( 'quiz-status', 'completed', $quiz->id ) && $remain = $user->can( 'retake-quiz', $quiz->id ) ): ?>
		<button
			class="button-retake-quiz"
			data-block-content="yes"
			data-id="<?php esc_attr_e( $quiz->id ); ?>"
			data-security="<?php esc_attr_e( wp_create_nonce( 'retake-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
			<?php echo esc_html( sprintf( '%s (+%d)', __( 'Retake', 'learnpress' ), $remain ) ); ?>
		</button>
	<?php endif; ?>

	<?php if ( $user->has_course_status( $course->id, array( 'enrolled' ) ) && !$user->has( 'started-quiz', $quiz->id, $course->id ) ): ?>
		<button
			class="button-start-quiz"
			data-block-content="yes"
			data-id="<?php esc_attr_e( $quiz->id ); ?>"
			data-security="<?php esc_attr_e( wp_create_nonce( 'start-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
			<?php esc_html_e( 'Start Quiz', 'learnpress' ); ?>
		</button>
	<?php endif; ?>

	<?php if ( in_array( $status, array( 'started' ) ) ): ?>
		<button
			class="button-finish-quiz"
			data-block-content="no"
			data-id="<?php esc_attr_e( $quiz->id ); ?>"
			data-security="<?php esc_attr_e( wp_create_nonce( 'finish-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
			<?php esc_html_e( 'Finish Quiz', 'learnpress' ); ?>
		</button>
	<?php endif; ?>

</div>