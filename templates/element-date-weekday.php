<?php
/**
 * Template: element-dropdown.php
 *
 * Available data: $id, $container_id, $label, $sort, $type, $value, $input_attrs, $label_required, $label_attrs, $wrap_attrs, $description, $description_attrs, $errors, $errors_attrs, $before, $after, $choices, $placeholder
 *
 * @package TorroForms
 * @since 1.0.0
 */

?>
<div<?php echo torro()->template()->attrs( $wrap_attrs ); ?>>
	<?php if ( ! empty( $before ) ) : ?>
		<?php echo $before; ?>
	<?php endif; ?>

	<label<?php echo torro()->template()->attrs( $label_attrs ); ?>>
		<?php echo torro()->template()->esc_kses_basic( $label ); ?>
		<?php echo torro()->template()->esc_kses_basic( $label_required ); ?>
	</label>

	<div>
		<?php if ( ! empty( $description ) ) : ?>
			<div<?php echo torro()->template()->attrs( $description_attrs ); ?>>
				<?php echo torro()->template()->esc_kses_basic( $description ); ?>
			</div>
		<?php endif; ?>

		<select<?php echo torro()->template()->attrs( $input_attrs ); ?>>
			<?php if ( ! empty( $placeholder ) ) : ?>
				<option value="">
					<?php echo torro()->template()->esc_html( $placeholder ); ?>
				</option>
			<?php endif; ?>

			<?php foreach ( $choices as $choice_value => $choice_label ) : ?>
				<?php $weekday = date_i18n('N', (new DateTime($choice_value))->getTimestamp()); ?>
				<option class="js-weekday-<?php echo torro()->template()->esc_attr( $weekday ); ?>" value="<?php echo torro()->template()->esc_attr( $choice_value ); ?>"<?php echo $value === $choice_value ? ' selected' : ''; ?>>
					<?php echo torro()->template()->esc_html( $choice_label ); ?>
				</option>
			<?php endforeach; ?>
		</select>

		<?php if ( ! empty( $errors ) ) : ?>
			<ul<?php echo torro()->template()->attrs( $errors_attrs ); ?> role="alert">
				<?php foreach ( $errors as $error_code => $error_message ) : ?>
					<li><?php echo torro()->template()->esc_kses_basic( $error_message ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $after ) ) : ?>
		<?php echo $after; ?>
	<?php endif; ?>
</div>
