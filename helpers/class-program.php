<?php

namespace Lkc\Helpers\Program;

class Program {

	public function __construct( private string $name, private string $slug ) {
	}

	/**
	 * Getter method for name property
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Getter method for name property
	 *
	 * @return string
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * Returns HTML for program sticker.
	 *
	 * @return void
	 */
	public function program_sticker(): void {
		echo "<div class=\"program-sticker program-sticker--$this->slug\">";
		echo '<i class="fas fa-chevron-right"></i>';
		echo "<span class=\"program-sticker__title\">$this->name</span>";
		echo "<i class=\"fas {$this->program_icon_class( $this->slug )}\"></i>";
		echo '</div>';
	}

	/**
	 * Returns class needed for specific program.
	 *
	 * @param string $program_slug
	 *
	 * @return string
	 */
	private function program_icon_class( string $program_slug ): string {
		return match ( $program_slug ) {
			'dramski-program' => 'fa-theater-masks',
			'deciji-program' => 'fa-child',
			'muzicki-program' => 'fa-music',
			'knjizevni-program' => 'fa-book-open',
			'likovni-program' => 'fa-book-open',
			'tribinski-program' => 'fa-book-open',
			'izdavacki-program' => 'fa-book-open',
			'filmski-program' => 'fa-book-open',
			'scenski-program' => 'fa-book-open',
			'amaterski-program' => 'fa-book-open',
			'umetnost-fotografije' => 'fa-book-open',
			'projektni-program' => 'fa-book-open',
			'odnos-s-javnoscu' => 'fa-book-open',
			default => 'fa-question'
		};
	}
}