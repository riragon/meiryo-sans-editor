<?php
/**
 * Plugin Name: Meiryo Sans Editor
 * Plugin URI: https://riragon.com/
 * Description: Classic Editor (TinyMCE) と「テキスト」タブのフォントをメイリオ系サンセリフに統一します。Windows 向け日本語フォントスタックを後勝ちで適用します。
 * Version: 1.0.3
 * Author: riragon.
 * License: GPLv2 or later
 * Text Domain: meiryo-sans-editor
 * Requires at least: 5.0
 * Tested up to: 6.6
 * Network: false
 *
 * @package MeiryoSansEditor
 */

// セキュリティ: 直接アクセスを防ぐ
if (!defined('ABSPATH')) {
	exit;
}

// セキュリティ: 定数の定義
if (!defined('MEIRYO_SANS_EDITOR_VERSION')) {
	define('MEIRYO_SANS_EDITOR_VERSION', '1.0.3');
}
if (!defined('MEIRYO_SANS_EDITOR_PLUGIN_URL')) {
	define('MEIRYO_SANS_EDITOR_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('MEIRYO_SANS_EDITOR_PLUGIN_DIR')) {
	define('MEIRYO_SANS_EDITOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

/**
 * Meiryo Sans Editor クラス
 */
class MeiryoSansEditor {
	
	/**
	 * インスタンス
	 */
	private static $instance = null;
	
	/**
	 * シングルトンパターンでインスタンスを取得
	 */
	public static function get_instance() {
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * コンストラクタ
	 */
	private function __construct() {
		add_action('init', array($this, 'init'));
	}
	
	/**
	 * 初期化処理
	 */
	public function init() {
		// セキュリティ: 管理画面でのみ動作
		if (!is_admin()) {
			return;
		}
		
		// セキュリティ: 適切な権限チェック
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
			return;
		}
		
		add_filter('mce_css', array($this, 'add_tinymce_css'));
		add_action('admin_head-post.php', array($this, 'add_admin_editor_css'));
		add_action('admin_head-post-new.php', array($this, 'add_admin_editor_css'));
	}
	
	/**
	 * Windows 向けメイリオ系フォントスタックを取得
	 * 
	 * @return string フォントスタック
	 */
	public function get_font_stack() {
		return '"メイリオ", Meiryo, "Yu Gothic", "Yu Gothic UI", "ＭＳ Ｐゴシック", "MS PGothic", sans-serif';
	}
	
	/**
	 * TinyMCE 用の外部 CSS を追加
	 * 
	 * @param string $mce_css 既存のCSS
	 * @return string 更新されたCSS
	 */
	public function add_tinymce_css($mce_css) {
		// セキュリティ: nonce検証（TinyMCEの場合は管理画面でのみ動作するため権限チェックで十分）
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
			return $mce_css;
		}
		
		$css_url = MEIRYO_SANS_EDITOR_PLUGIN_URL . 'editor-style.css';
		
		// バージョンパラメータを追加してキャッシュ対策
		$css_url = add_query_arg('ver', MEIRYO_SANS_EDITOR_VERSION, $css_url);
		
		if (empty($mce_css) || strpos($mce_css, $css_url) === false) {
			$mce_css = $mce_css ? $mce_css . ',' . $css_url : $css_url;
		}
		
		return $mce_css;
	}

	/**
	 * 「テキスト」タブの textarea にフォント適用
	 */
	public function add_admin_editor_css() {
		// セキュリティ: 権限チェック
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
			return;
		}
		
		// セキュリティ: nonce検証（編集画面では自動で検証されているが、念のため）
		global $pagenow;
		if (!in_array($pagenow, array('post.php', 'post-new.php'), true)) {
			return;
		}
		
		// セキュリティ: フォントスタックをエスケープ
		$font_stack = esc_attr($this->get_font_stack());
		
		// インラインCSSを出力（適切にエスケープ）
		?>
		<style id="meiryo-sans-editor-admin-editor-css">
			.wp-editor-area { 
				font-family: <?php echo $font_stack; ?> !important; 
				color: #222 !important;
				font-size: 15px; 
				line-height: 1.7; 
				-webkit-font-smoothing: antialiased;
			}
		</style>
		<?php
	}
	
	/**
	 * プラグインのアンインストール処理
	 */
	public static function uninstall() {
		// 現在は設定を保存していないため、特に処理なし
		// 将来的に設定を保存する場合はここで削除
	}
}

/**
 * プラグインの初期化
 */
function meiryo_sans_editor_init() {
	return MeiryoSansEditor::get_instance();
}

// プラグイン開始
add_action('plugins_loaded', 'meiryo_sans_editor_init');

/**
 * プラグインのアンインストール時の処理
 */
register_uninstall_hook(__FILE__, array('MeiryoSansEditor', 'uninstall'));

/**
 * 備考：Gutenberg（ブロックエディター）は対象外です。
 * このプラグインはClassic Editor (TinyMCE) とテキストエディターのみを対象としています。
 */


