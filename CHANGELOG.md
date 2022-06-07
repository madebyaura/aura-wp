## 3.0.0

feat!: add dynamic hooks to `Theme::get_template_part()`.
dx: change minimum PHP version to 7.4.

## 2.0.0

refactor: rename PostLoop to EntryLoop

## 1.3.6

- fix: ACF CSS on user screens.

## 1.3.5

- fix: ACF group CSS.

## 1.3.4

- fix: no arguments were being passed to pagination in `PostLoop->render_posts`.

## 1.3.3

- fix: pass `WP_Query` instance to pagination template part in `render_posts` method of `PostLoop` class.

## 1.3.2

- fix: pagination should be outside posts in `PostLoop` class.
- qc: remove closing html tag comments.

## 1.3.1

- fix: add multiple plugin support to `Plugin::get_info()`.

## 1.3.0

- Add `PageTitle` class.

## 1.2.0

- Add `Plugin::get_info()`.

## v1.1.1

- Fix CSS for ACF repeater fields

## 1.1.0

- Add `ACF::echo_admin_css()`.

## 1.0.1

- Fix `Utils::is_plugin_active()`.

## 1.0.0

- Initial release.
