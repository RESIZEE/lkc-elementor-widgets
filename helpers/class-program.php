<?php

namespace Lkc\Helpers\Program;

class Program {

	public string $name;
	public string $slug;

	public function __construct( string $name, string $slug ) {
		$this->name = $name;
		$this->slug = $slug;
	}

	/**
	 * Returns HTML for program sticker.
	 *
	 * @return void
	 */
	public function program_sticker(): void {
		//echo '<a href="' . ($this->slug != 'none' ? '/' . $this->slug : '#') . '">';
		echo "<div class=\"program-sticker program-sticker--$this->slug\">";
		echo '<i class="fas fa-chevron-right"></i>';
		echo "<span class=\"program-sticker__title\">$this->name</span>";
		echo "<i class=\"fas {$this->program_icon_class( $this->slug )}\"></i>";
		echo '</div>';
		//echo '</a>';
	}

	/**
	 * Returns class needed for specific program.
	 *
	 * @param string $program_slug
	 *
	 * @return string
	 */
	private function program_icon_class( string $program_slug ): string {
		switch ( $program_slug ) {
			case 'scenski-program':
				return 'fa-theater-masks';
			case 'deciji-program':
				return 'fa-child';
			case 'muzicki-program':
				return 'fa-music';
			case 'knjizevni-program':
				return 'fa-book-open';
			case 'likovni-program':
				return 'fa-palette';
			case 'tribinski-program':
				return 'fa-users';
			case 'izdavacki-program':
				return 'fa-book';
			case 'filmski-program':
				return 'fa-film';
			case 'amaterski-program':
				return 'fa-theater-masks';
			case 'umetnost-fotografije':
				return 'fa-camera';
			case 'projektni-program':
				return 'fa-file';
			case 'odnos-s-javnoscu':
				return 'fa-bullhorn';
			default:
				return 'fa-question';
		}
	}
}
