<?php

class ameFormBuilder {
	protected $action = '';
	protected $submitUrl = '';
	protected $settings = array();

	protected $inputIdPrefix = 'ame-';

	protected $sections = array();
	protected $fields = array();
	protected $nodes = array();

	protected $currentSection = 0;
	protected $currentField = 0;

	protected $isColorPickerRequired = false;
	protected $defaultSubmitButtonEnabled = true;

	protected function __construct($action, $submitUrl, $settings) {
		$this->action = $action;
		$this->submitUrl = $submitUrl;
		$this->settings = $settings;
	}

	public static function form($action = '', $submitUrl = '', $currentSettings = array()) {
		return new static($action, $submitUrl, $currentSettings);
	}

	public function idPrefix($prefix) {
		$this->inputIdPrefix = $prefix;
	}

	public function section($title = '', $options = array()) {
		$this->sections[] = array_merge(
			array(
				'title'  => $title,
				'fields' => array(),
			),
			$options
		);
		$this->currentSection = count($this->sections) - 1;
		$this->currentField = '';
		return $this;
	}

	public function field($title, $name, $options = array()) {
		$inputId = $this->inputIdPrefix . $name;
		$this->sections[$this->currentSection]['fields'][] = $name;

		$this->fields[$name] = array_merge(
			array(
				'name'          => $name,
				'title'         => $title,
				'default'       => null,
				'labelFor'      => null,
				'inputId'       => $inputId,
				'hasInputNodes' => false,
			),
			$options
		);
		$this->currentField = $name;
		return $this;
	}

	public function fullWidthField($name) {
		$this->field('Full-width field: ' . $name, $name);
		$this->fields[$this->currentField]['isFullWidth'] = true;
		return $this;
	}

	public function defaultValue($value) {
		$this->fields[$this->currentField]['default'] = $value;
		return $this;
	}

	public function textBox($options = array()) {
		return $this->addInputElement(
			'outputTextBox',
			array('type' => 'text'),
			$options
		);
	}

	public function textArea($options = array()) {
		return $this->addInputElement('outputTextArea', array(), $options);
	}

	public function editor($options = array()) {
		return $this->addInputElement(
			'outputWpEditor',
			array(
				'rows'  => 6,
				'teeny' => true,
			),
			$options
		);
	}

	public function checkbox($label = null) {
		return $this->addInputElement('outputCheckbox', array('label' => $label));
	}

	public function radioGroup($items = array()) {
		return $this->addInputElement(
			'outputRadioGroup',
			array(
				'parentLabelEnabled' => false,
				'items'              => $items,
			)
		);
	}

	public function colorPicker($options = array()) {
		$this->addInputElement(
			'outputColorPicker',
			array(
				'parentLabelEnabled' => false,
			),
			$options
		);
		$this->isColorPickerRequired = true;
	}

	public function imageSelector($options = array()) {
		return $this->addInputElement(
			'outputImageSelector',
			array('parentLabelEnabled' => false),
			$options
		);
	}

	public function html($rawHtml) {
		$this->nodes[$this->currentField][] = array(
			'callback' => array($this, 'outputRawHtml'),
			'content'  => $rawHtml,
		);
		return $this;
	}

	public function submitButton($wrap = true) {
		$this->nodes[$this->currentField][] = array(
			'callback' => array($this, 'outputSubmitButton'),
			'wrap'     => $wrap,
		);
		$this->defaultSubmitButtonEnabled = false;
		return $this;
	}

	protected function addInputElement($callbackMethod, $nodeDefaults = array(), $options = array()) {
		$isFirstInput = !$this->fields[$this->currentField]['hasInputNodes'];

		$defaultId = null;
		if ( $isFirstInput ) {
			$defaultId = $this->fields[$this->currentField]['inputId'];
		}

		$options = array_merge(
			array(
				'id'                 => $defaultId,
				'parentLabelEnabled' => true,
				'callback'           => array($this, $callbackMethod),
				'name'               => $this->currentField,
			),
			$nodeDefaults,
			$options
		);

		if ( $options['parentLabelEnabled'] && $isFirstInput ) {
			$this->fields[$this->currentField]['labelFor'] = $options['id'];
		}
		$this->fields[$this->currentField]['hasInputNodes'] = true;

		$this->nodes[$this->currentField][] = $options;
		return $this;
	}

	public function output() {
		$formId = 'ame-form-' . time();

		printf('<form action="%s" method="post" id="%s">', esc_attr($this->submitUrl), esc_attr($formId));

		wp_nonce_field($this->action);
		printf('<input type="hidden" name="action" value="%s">', esc_attr($this->action));

		$this->outputAllSections();

		if ( $this->defaultSubmitButtonEnabled ) {
			submit_button('Save Changes');
		}

		echo '</form>';

		if ( $this->isColorPickerRequired ) {
			if ( !wp_script_is('wp-color-picker', 'enqueued') && !wp_script_is('wp-color-picker', 'done') ) {
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_style('wp-color-picker');
			}
			?>
			<script type="text/javascript">
				var formId = '<?php echo esc_js($formId); ?>';
				jQuery(function ($) {
					$('#' + formId).find('.ame-color-picker').css('visibility', 'visible').wpColorPicker();
				});
			</script>
			<?php
		}
	}

	protected function outputAllSections() {
		foreach ($this->sections as $options) {
			$this->outputSection($options);
		}
	}

	protected function outputSection($section) {
		echo $this->createTag(
			'div',
			array(
				'class' => 'ame-form-section',
				'id'    => ameUtils::get($section, 'id'),
			),
			$section
		);

		if ( !empty($section['title']) ) {
			printf("<h2>%s</h2>\n", $section['title']);
		}
		if ( !empty($section['description']) ) {
			echo '<p>' . $section['description'] . '</p>';
		}
		if ( !empty($section['fields']) ) {
			echo '<table class="form-table">';
			foreach ($section['fields'] as $name) {
				$this->outputField($name, $this->fields[$name]);
			}
			echo "</table>\n";
		}

		echo '</div>';
	}

	protected function outputField($name, $options) {
		echo "<tr>\n\t";

		if ( empty($options['isFullWidth']) ) {
			echo '<th scope="row">';

			$before = $after = '';
			if ( !empty($options['labelFor']) ) {
				$before = sprintf('<label for="%s">', esc_attr($options['labelFor']));
				$after = '</label>';
			}

			echo $before, $options['title'], $after;
			echo "</th>\n\t<td>";
		} else {
			echo '<td class="td-full" colspan="2">';
		}

		if ( isset($this->nodes[$name]) ) {
			foreach ($this->nodes[$name] as $node) {
				call_user_func($node['callback'], $node, $options);
			}
		}
		echo "</td>\n</tr>\n";
	}

	public function outputSingleField($name) {
		$this->outputField($name, $this->fields[$name]);
	}

	protected function outputTextBox($options) {
		$name = $options['name'];

		echo $this->createTag(
			'input',
			array(
				'type'  => $options['type'],
				'name'  => $name,
				'value' => $this->getFieldValue($name, ''),
				'id'    => $options['id'],
				'class' => 'regular-text',
			),
			$options
		);

		$this->outputDescription($options);
	}

	protected function outputCheckbox($options) {
		$name = $options['name'];
		$isChecked = $this->getFieldValue($name, false);

		/** @noinspection HtmlUnknownAttribute */
		printf(
			'<label><input type="checkbox" name="%s" id="%s" %s> %s</label>',
			esc_attr($name),
			esc_attr($options['id']),
			$isChecked ? ' checked="checked" ' : '',
			isset($options['label']) ? $options['label'] : $name
		);
	}

	protected function outputTextArea($options) {
		$name = $options['name'];

		printf(
			'<textarea name="%s" id="%s" cols="100" rows="5" class="large-text">%s</textarea>',
			esc_attr($name),
			esc_attr($options['id']),
			esc_textarea($this->getFieldValue($name, ''))
		);
		$this->outputDescription($options);
	}

	protected function outputRadioGroup($options) {
		$name = $options['name'];
		$currentSetting = $this->getFieldValue($name);

		echo '<fieldset>';
		foreach ($options['items'] as $value => $label) {
			/** @noinspection HtmlUnknownAttribute */
			printf(
				'<label><input type="radio" name="%s" value="%s" %s> %s</label><br>',
				esc_attr($name),
				esc_attr($value),
				($value === $currentSetting) ? ' checked="checked" ' : '',
				$label
			);
		}
		echo '</fieldset>';
	}

	protected function outputImageSelector($options) {
		$name = $options['name'];

		$attachmentId = $this->getFieldValue($name, 0);
		if ( !empty($attachmentId) ) {
			$imageUrl = wp_get_attachment_image_url($attachmentId, 'full');
			if ( !$imageUrl ) {
				$attachmentId = 0;
			}
		}

		$externalUrlsAllowed = isset($options['externalUrlsAllowed']) ? $options['externalUrlsAllowed'] : true;
		$externalUrlField = null;
		if ( $externalUrlsAllowed ) {
			$externalUrlField = isset($options['externalUrlField'])
				? $options['externalUrlField']
				: ($name . '_external_url');
		}
		$externalUrl = $this->getFieldValue($externalUrlField, '');

		if ( empty($imageUrl) && !empty($externalUrl) ) {
			$imageUrl = $externalUrl;
		}

		//Note: Consider adding allowExternalUrls(optionName)

		$disabledAttr = '';
		if ( !current_user_can('upload_files') ) {
			$disabledAttr = ' disabled="disabled"';
		}
		?>
		<div class="ame-image-selector">
			<?php if ( defined('IS_DEMO_MODE') && constant('IS_DEMO_MODE') ): ?>
				<p><em>Sorry, this feature is not available in the demo because image upload is disabled.</em></p>
			<?php endif; ?>
			<div class="ame-image-preview"><?php
				printf(
					'<span class="ame-image-preview-placeholder" style="%s">No image selected</span>',
					empty($imageUrl) ? '' : 'display: none;'
				);
				if ( !empty($imageUrl) ) {
					printf('<img src="%s" alt="Image preview">', esc_attr($imageUrl));
				}
				?></div>
			<input type="hidden" name="<?php echo esc_attr($name); ?>" class="ame-image-attachment-id"
			       value="<?php echo esc_attr($attachmentId); ?>">

			<?php if ( $externalUrlsAllowed ): ?>
				<div class="ame-external-image-url-preview" <?php
				if ( empty($externalUrl) ) {
					echo ' style="display: none" ';
				}
				?>>
					<label>
						<input type="text" name="<?php echo esc_attr($externalUrlField); ?>"
						       class="regular-text large-text code ame-external-image-url"
						       placeholder="Image URL"
						       value="<?php echo esc_attr($externalUrl); ?>" readonly="readonly">
						<span class="sr-only">External image URL</span>
					</label>
				</div>
			<?php endif; ?>

			<div class="ame-image-selector-actions">
				<input type="button" class="button button-secondary ame-select-image"
				       value="Select Image" <?php echo $disabledAttr; ?>>
				<?php if ( $externalUrlsAllowed ): ?>
					<input type="button" class="button button-secondary ame-set-external-image-url"
					       value="Set External URL" <?php echo $disabledAttr; ?>>
				<?php endif; ?>
				<a href="#" class="ame-remove-image-link"<?php
				if ( empty($attachmentId) && empty($externalUrl) ) {
					echo ' style="display: none;" ';
				}
				?>>Remove Image</a>
			</div>
			<?php $this->outputDescription($options); ?>
		</div>
		<?php
	}

	protected function outputDescription($options) {
		if ( !empty($options['description']) ) {
			printf('<p class="description">%s</p>', $options['description']);
		}
	}

	protected function outputRawHtml($options) {
		echo $options['content'];
	}

	protected function outputWpEditor($options) {
		wp_editor(
			$this->getFieldValue($options['name'], ''),
			//The ID must only contain lowercase letters and underscores.
			preg_replace('/[^a-z_]/', '_', $options['id']),
			array(
				'textarea_name' => $options['name'],
				'textarea_rows' => $options['rows'],
				'teeny'         => $options['teeny'],
				'wpautop'       => true,
			)
		);
	}

	protected function outputColorPicker($options) {
		echo $this->createTag(
			'input',
			array(
				'type'  => 'text',
				'class' => 'ame-color-picker',
				'id'    => $options['id'],
				'name'  => $options['name'],
				'value' => $this->getFieldValue($options['name'], ''),
				'style' => 'visibility: hidden',
			),
			$options
		);
	}

	protected function outputSubmitButton($options) {
		submit_button(null, 'primary', 'submit', $options['wrap']);
	}

	protected function getFieldValue($name, $defaultValue = null) {
		if ( isset($this->fields[$name]['default']) ) {
			$defaultValue = $this->fields[$name]['default'];
		}

		//Convert input array names like "collection[key]" to dot-separated syntax like "collection.key".
		$name = preg_replace('/\[([\w\-_]+?)\]/', '.$1', $name);

		return ameUtils::get($this->settings, $name, $defaultValue);
	}

	protected function createTag($tagName, $attributes = array(), $options = array()) {
		$html = '<' . $tagName;
		$charset = $this->getCharset();

		if ( isset($options['class']) ) {
			$attributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '') . ' ' . $options['class'];
		}
		if ( isset($options['attr']) ) {
			$attributes = array_merge($attributes, $options['attr']);
		}

		$attributes = array_filter($attributes, array($this, 'isNonEmptyAttributeValue'));
		if ( !empty($attributes) ) {
			$stringPairs = array();
			foreach ($attributes as $name => $value) {
				//esc_attr() doesn't double-encode entities, so let's use htmlspecialchars() instead.
				$stringPairs[] = $name . '="' . htmlspecialchars($value, ENT_QUOTES, $charset) . '"';
			}
			$html .= ' ' . implode(' ', $stringPairs);
		}

		$html .= '>';
		if ( ameUtils::get($options, 'content') !== null ) {
			$html .= $options['content'] . '</' . $tagName . '>';
		}

		return $html;
	}

	private function isNonEmptyAttributeValue($value) {
		return ($value !== null) && ($value !== false);
	}

	private function getCharset() {
		static $charset = null;
		if ( $charset === null ) {
			$charset = get_option('blog_charset', '');
			if ( in_array($charset, array('utf8', 'utf-8', 'UTF8')) ) {
				$charset = 'UTF-8';
			}
		}
		return $charset;
	}
}