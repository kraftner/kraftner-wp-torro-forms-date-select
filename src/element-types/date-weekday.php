<?php
/**
 * Date element type class
 *
 * @package KraftnerWpTorroFormsDateSelect
 * @since 1.0.0
 */

namespace Kraftner\KraftnerWpTorroFormsDateSelect\Element_Types;

use awsmug\Torro_Forms\DB_Objects\Elements\Element;
use awsmug\Torro_Forms\DB_Objects\Elements\Element_Types\Base\Dropdown;
use DateTime;

/**
 * Class representing a dropdown-based date element type.
 *
 * @since 1.0.0
 */
class Date_Weekday extends Dropdown {

	/**
	 * Gets the fields arguments for an element of this type when editing submission values in the admin.
	 *
	 * @since 1.0.0
	 *
	 * @param Element $element Element to get fields arguments for.
	 * @return array An associative array of `$field_slug => $field_args` pairs.
	 */
	public function get_edit_submission_fields_args( $element ) {
		$fields = parent::get_edit_submission_fields_args( $element );

		$slug = $this->get_edit_submission_field_slug( $element->id );

		$fields[ $slug ]['type']  = 'datetime';
		$fields[ $slug ]['store'] = 'date';

		return $fields;
	}

	/**
	 * Bootstraps the element type by setting properties.
	 *
	 * @since 1.0.0
	 */
	protected function bootstrap() {
		$this->slug        = 'date-weekday';
		$this->title       = __( 'Date Weekday Dropdown', 'kraftner-wp-torro-forms-date-select' );
		$this->description = __( 'A dropdown listing all days for selected weekdays X days into the future.', 'kraftner-wp-torro-forms-date-select' );
		$this->icon_svg_id = 'torro-icon-textfield';

		$this->add_description_settings_field();
		$this->add_required_settings_field();
		$this->settings_fields['max_days_from_now'] = array(
			'section'       => 'settings',
			'type'          => 'number',
			'label'         => __( 'Number of Days in the future', 'kraftner-wp-torro-forms-date-select' ),
			'default'       => 100,
			'min'			=> 1,
			'max'			=> 500
		);
		$this->settings_fields['show_mondays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Mondays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_tuesdays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Tuesdays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_wednesdays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Wednesdays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_thursdays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Thursdays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_fridays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Fridays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_saturdays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Saturdays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->settings_fields['show_sundays'] = array(
			'section'       => 'settings',
			'type'          => 'radio',
			'label'         => __( 'Show Sundays', 'kraftner-wp-torro-forms-date-select' ),
			'choices'     => [
				'yes' => __( 'Yes', 'kraftner-wp-torro-forms-date-select' ),
				'no'  => __( 'No', 'kraftner-wp-torro-forms-date-select' ),
			],
			'default'     => 'yes',
		);
		$this->add_css_classes_settings_field();
	}

	/**
	 * Returns the available choices.
	 *
	 * @param Element $element Element to get choices for.
	 * @return array Associative array of `$field => $choices` pairs, with the main element field having the key '_main'.
	 * @throws \Exception
	 * @since 1.0.0
	 *
	 */
	public function get_choices( $element ) {

		$settings = $this->get_settings( $element );

		$date_format = get_option( 'date_format' );

		$max_days_from_now = min((int) $settings['max_days_from_now'], 500);

		$cutOffDate = new DateTime('+' . $max_days_from_now . ' days');
		$date = new DateTime();
		//The start date is tomorrow.
		$date->modify('+1 day');

		$choices = [
			'_main' =>  []
		];

		while($cutOffDate > $date){

			if($this->show_day($settings, $date)){
				$choices['_main'][$date->format('Y-m-d')] = date_i18n('l, ' . $date_format, $date->getTimestamp());
			}
			$date->modify('+1 day');
		}

		return $choices;
	}

	protected function show_day(array $settings, DateTime $date){

		$weekday = $date->format('N');

		if( $weekday === '1' &&  $settings['show_mondays']    === 'yes') return true;
		if( $weekday === '2' &&  $settings['show_tuesdays']   === 'yes') return true;
		if( $weekday === '3' &&  $settings['show_wednesdays'] === 'yes') return true;
		if( $weekday === '4' &&  $settings['show_thursdays']  === 'yes') return true;
		if( $weekday === '5' &&  $settings['show_fridays']    === 'yes') return true;
		if( $weekday === '6' &&  $settings['show_saturdays']  === 'yes') return true;
		if( $weekday === '7' &&  $settings['show_sundays']    === 'yes') return true;

		return false;

	}

}
