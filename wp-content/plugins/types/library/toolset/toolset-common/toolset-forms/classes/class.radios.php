<?php

/**
 *
 *
 */
require_once 'class.field_factory.php';

/**
 * Description of class
 *
 * @author Srdjan
 */
class WPToolset_Field_Radios extends FieldFactory {

    public function metaform() {
        $value = $this->getValue();
        $data = $this->getData();
        $name = $this->getName();
        $form = array();
        $options = array();

//        if (!is_admin()) {
//            $new_options = array();
//            foreach ($data['options'] as $key => $option) {
//                $tmp = $option['value'];
//                $option['value'] = $option['types-value'];
//                $option['types-value'] = $tmp;
//                $new_options[$key] = $option;
//                unset($tmp);
//            }
//            $data['options'] = $new_options;
//        }

        foreach ($data['options'] as $option) {
            $one_option_data = array(
                '#value' => $option['value'],
                '#title' => $option['title'],
                '#validate' => $this->getValidationData()
            );

            if (!is_admin()) {// TODO maybe add a doing_ajax() check too, what if we want to load a form using AJAX?
                $clases = array(
                    'wpt-form-item',
                    'wpt-form-item-radio',
                    'radio-' . sanitize_title($option['title'])
                );
                /**
                 * filter: cred_checkboxes_class
                 * @param array $clases current array of classes
                 * @parem array $option current option
                 * @param string field type
                 *
                 * @return array
                 */
                $clases = apply_filters('cred_item_li_class', $clases, $option, 'radio');
                $one_option_data['#before'] = sprintf(
                        '<li class="%s">', implode(' ', $clases)
                );
                $one_option_data['#after'] = '</li>';
                //moved error from element to before prefix
                $one_option_data['#pattern'] = '<BEFORE><ERROR><PREFIX><ELEMENT><LABEL><SUFFIX><DESCRIPTION><AFTER>';
            }
            /**
             * add default value if needed
             * issue: frontend, multiforms CRED
             */
//            if (array_key_exists('types-value', $option)) {
//                $one_option_data['#types-value'] = $option['types-value'];
//            }
            /**
             * add to options array
             */
            $options[] = $one_option_data;
        }
        /**
         * for user fields we reset title and description to avoid double
         * display
         */
        $title = $this->getTitle();
        if (empty($title)) {
            $title = $this->getTitle(true);
        }
        $options = apply_filters('wpt_field_options', $options, $title, 'select');
        /**
         * default_value
         */
        if (!empty($value) || $value == '0') {
            $data['default_value'] = $value;
        }
        /**
         * metaform
         */
        $form_attr = array(
            '#type' => 'radios',
            '#title' => $this->getTitle(),
            '#description' => $this->getDescription(),
            '#name' => $name,
            '#options' => $options,
            '#default_value' => isset($data['default_value']) ? $data['default_value'] : false,
            '#repetitive' => $this->isRepetitive(),
            '#validate' => $this->getValidationData(),
			'wpml_action' => $this->getWPMLAction(),
            '#after' => '<input type="hidden" name="_wptoolset_radios[' . $this->getId() . ']" value="1" />',
        );

        if (!is_admin()) {// TODO maybe add a doing_ajax() check too, what if we want to load a form using AJAX?
            $form_attr['#before'] = '<ul class="wpt-form-set wpt-form-set-radios wpt-form-set-radios-' . $name . '">';
            $form_attr['#after'] = '</ul>';
        }

        $form[] = $form_attr;

        return $form;
    }

}
