Windows 環境の WordPress で、Classic Editor (TinyMCE) と「テキスト」タブのフォントをメイリオ系サンセリフに統一し、日本語の可読性を高めるシンプルなプラグインです。

![Uploading bandicam 2025-09-15 10-25-47-356.jpg…]()


環境によってはWordPressに問題を起こすことがあるかもしれない。必ずテスト環境で試すか、問題が発生したときにFTPでログインして対応できるようにしてからチャレンジしてください。Classic Editor プラグインの併用が必要です。

### かんたんなつかいかた（Windows）
まずはgitからzipをダウンロードして解凍します。
フォルダーを開いてmeiryo-sans-editor.zipを見つけてください。

1. WordPress にログイン → プラグイン → 新規追加 → プラグインのアップロード。
2. `meiryo-sans-editor.zip` をえらんでインストール → 「有効化」をおします。
3. 投稿や固定ページの編集画面をひらくと、文字が読みやすくなります。
4. かわらないときは、画面を更新したり、キャッシュをけしてみてください。

## Meiryo Sans Editor

Windows 環境の WordPress で、Classic Editor (TinyMCE) と「テキスト」タブのフォントをメイリオ系サンセリフに統一し、日本語の可読性を高めるシンプルなプラグインです。

- **対象エディター**: Classic Editor のビジュアル (TinyMCE) と「テキスト」タブ
- **非対応**: Gutenberg（ブロックエディター）
- **想定 OS**: Windows 10 / 11
- **WordPress 要件**: 5.0 以上（Tested up to 6.6）
- **プラグイン版数**: 1.0.3

### 特長
- **Windows に最適化**: 日本語表示に適したフォントスタック（メイリオ系）を後勝ちで適用
- **一貫した表示**: エディター内の主要テキスト要素へフォントを継承
- **軽量・設定不要**: 有効化するだけで動作、設定画面なし
- **衝突しにくい**: テーマや他プラグインに影響を与えにくい最小限の CSS

### 仕組み（ざっくり）
- TinyMCE 用に `editor-style.css` を読み込み、本文と主要要素にフォントを適用
- 投稿編集画面の「テキスト」タブの `textarea`（`.wp-editor-area`）にインライン CSS を出力
- フォントスタックは `"メイリオ", Meiryo, "Yu Gothic", "Yu Gothic UI", "ＭＳ Ｐゴシック", "MS PGothic", sans-serif`

### フォルダー構成
- `meiryo-sans-editor/meiryo-sans-editor.php`: プラグイン本体
- `meiryo-sans-editor/editor-style.css`: TinyMCE 用スタイル

### インストール（Windows）
1. **ZIP で導入**（推奨）
   - このリポジトリ内の `meiryo-sans-editor` フォルダーを ZIP 圧縮し、`meiryo-sans-editor.zip` を作成
   - WordPress 管理画面 → プラグイン → 新規追加 → プラグインのアップロード → ZIP を選択してインストール
   - 「有効化」をクリック
2. **手動設置**
   - エクスプローラーで WordPress の `wp-content\plugins\` に `meiryo-sans-editor` フォルダーをそのまま配置
   - 管理画面 → プラグイン で「Meiryo Sans Editor」を有効化

補足: ビジュアルエディターでの反映には Classic Editor プラグインの併用が必要です。（[Classic Editor](https://ja.wordpress.org/plugins/classic-editor/)）。

### 使い方
- 有効化後、投稿・固定ページの編集画面を開くと、エディター内の日本語フォントがメイリオ系に統一されます。
- 反映されない場合は、ブラウザーキャッシュやサーバーのキャッシュプラグインを一度クリアしてください。

### カスタマイズ
- **フォントの変更**: `meiryo-sans-editor.php` 内の `get_font_stack()` を編集
- **サイズや行間の調整**: `editor-style.css` または `add_admin_editor_css()` の出力値（`.wp-editor-area`）を調整
- **テーマや他プラグインとの競合**: 本プラグインは `!important` を活用しエディター内で後勝ちする設計ですが、競合がある場合は当該プラグインの設定でフォント指定をオフにするか、CSS の優先度を調整してください。

### トラブルシューティング
- **フォントが変わらない**
  - 現在の編集画面が Gutenberg（ブロックエディター）でないか確認（本プラグインは対象外）
  - Classic Editor プラグインを導入し、Classic 画面で確認
  - キャッシュ（ブラウザー/サーバー/CDN）をクリア
  - 他のエディター系プラグインが `mce_css` を上書きしていないか確認
- **文字のにじみ/細く見える**
  - ディスプレイのスケーリングや ClearType 設定の見直しを検討
  - 必要に応じて `editor-style.css` で `font-size` や `-webkit-font-smoothing` を調整

### アンインストール
- プラグインを「停止」→「削除」すれば、設定やデータは残りません（設定は保存していません）。

### ライセンスと著作権
- **ライセンス**: GPLv2 or later
- **著作**: riragon.

### 変更履歴（抜粋）
- 1.0.3: 動作安定化、WordPress 6.6 での動作確認

### 注意事項
- 本プラグインは **Windows 環境向け** に最適化されています。macOS や Linux では同等のフォントが存在しないため意図通り表示されない場合があります。
- エディター専用のスタイルです。サイトの公開側（フロントエンド）のフォントには影響しません。



