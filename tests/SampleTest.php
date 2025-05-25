<?php
class SampleTest extends WP_UnitTestCase {
	protected bool $is_action_called = false;

	public function test_add_action_triggers_callback(): void {
		add_action( 'my_custom_action', array( $this, 'action_callback' ) );
		do_action( 'my_custom_action' );

		$this->assertTrue( $this->is_action_called );
	}

	public function action_callback(): void {
		$this->is_action_called = true;
	}

	public function test_add_filter_modifies_value(): void {
		add_filter( 'my_custom_filter', array( $this, 'filter_callback' ) );

		$modified = apply_filters( 'my_custom_filter', 'Original' );

		$this->assertEquals( 'Modified: Original', $modified );
	}

	public function filter_callback( string $value ): string {
		return 'Modified: ' . $value;
	}

	public function test_get_post_meta_returns_expected_value(): void {
		$post_id = self::factory()->post->create(
			array(
				'post_title' => 'Test post',
			)
		);

		update_post_meta( $post_id, 'my_meta_key', 'my_meta_value' );

		$retrieved = get_post_meta( $post_id, 'my_meta_key', true );

		$this->assertEquals( 'my_meta_value', $retrieved );
	}
}
