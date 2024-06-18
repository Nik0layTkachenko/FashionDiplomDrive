<?php

class ameBoxyFormBuilder extends ameFormBuilder {
	protected $styleHandle = 'ame-form-box-styles';

	protected $isInSidebar = false;
	protected $hasSidebar = false;
	protected $sidebarOptions = array();

	protected $lastMainColumnSection = null;

	public function sidebar($options = array()) {
		$this->isInSidebar = true;
		$this->hasSidebar = true;
		$this->lastMainColumnSection = $this->currentSection;
		$this->sidebarOptions = $options;
	}

	protected function outputSection($section) {
		echo $this->createTag(
			'div',
			array(
				'class' => 'ame-form-section ame-form-box',
				'id'    => ameUtils::get($section, 'id'),
			),
			$section
		);

		if ( !empty($section['title']) ) {
			echo '<div class="ame-form-box-header">';
			printf("<h2 class='ame-form-box-title'>%s</h2>\n", $section['title']);
			echo '</div>';
		}

		if ( !empty($section['description']) ) {
			echo '<p>' . $section['description'] . '</p>';
		}
		if ( !empty($section['fields']) ) {
			echo '<div class="ame-form-box-content">';
			foreach ($section['fields'] as $name) {
				$this->outputField($name, $this->fields[$name]);
			}
			echo "</div>\n";
		}

		echo '</div>';
	}

	protected function outputAllSections() {
		if ( !$this->hasSidebar ) {
			parent::outputAllSections();
		} else {
			$columns = array('main' => array(), 'sidebar' => array());
			$currentColumn = 'main';
			foreach ($this->sections as $key => $section) {
				$columns[$currentColumn][] = $section;

				if ( $this->lastMainColumnSection === $key ) {
					$currentColumn = 'sidebar';
				}
			}

			$style = '';
			if ( isset($this->sidebarOptions['mainColumnWidth']) ) {
				$style .= sprintf('width: %dpx;', $this->sidebarOptions['mainColumnWidth']);
			}
			printf('<div class="ame-form-box-main-column" style="%s">', $style);
			foreach ($columns['main'] as $section) {
				$this->outputSection($section);
			}
			echo '</div>';

			echo '<div class="ame-form-box-sidebar-column">';
			foreach ($columns['sidebar'] as $section) {
				$this->outputSection($section);
			}
			echo '</div>';
			echo '<div class="clear"></div>';
		}
	}

	public function output() {
		if ( !wp_style_is($this->styleHandle, 'enqueued') && !wp_style_is($this->styleHandle, 'done') ) {
			wp_enqueue_auto_versioned_style(
				$this->styleHandle,
				plugins_url('assets/form-boxes.css', AME_BRANDING_ADD_ON_FILE)
			);
		}
		parent::output();
	}

	protected function outputField($name, $options) {
		echo $this->createTag(
			'div',
			array('class' => 'ame-form-box-field', 'id' => 'ame-field-row-' . $name),
			$options
		), "\n\t";

		if ( empty($options['isFullWidth']) ) {
			echo '<div class="ame-form-box-field-title">';

			$before = $after = '';
			if ( !empty($options['labelFor']) ) {
				$before = sprintf('<label for="%s">', esc_attr($options['labelFor']));
				$after = '</label>';
			}

			echo $before, $options['title'], $after;
			echo "</div>\n\t";
		}

		$contentClasses = array('ame-form-box-field-content');
		if ( !empty($options['isFullWidth']) ) {
			$contentClasses[] = 'ame-form-box-full-width-content';
		}
		echo '<div class="' . implode(' ', $contentClasses) . '">';

		if ( isset($this->nodes[$name]) ) {
			foreach ($this->nodes[$name] as $node) {
				call_user_func($node['callback'], $node, $options);
			}
		}
		echo "</div>\n</div>\n";
	}
}