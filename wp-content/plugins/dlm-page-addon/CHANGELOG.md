#### 4.1.1: February 20, 2018
* Tweak: Fixed error in title on Sub-Category overview pages.

#### 4.1.0: February 8, 2018
* Feature: Downloads in search results can now link to Page Addon information detail page.
* Tweak: Fixed the need of re-saving the permalinks after plugin activation by better flushing from within plugin.
* Tweak: Fixed incorrect download count in category title. 
* Tweak: Tweaked the way download content is displayed on single page (better support for paragraphs, shortcodes, etc.)
* Tweak: General code rewrites & clean up.

#### 4.0.1: January 26, 2018
* Tweak: Fixed an XSS issue on download tag overview pages.

#### 4.0.0: January 20, 2018
* Tweak: Made Page Addon compatible with Download Monitor 4.0
* Tweak: Made category wrapper element filterable via dlm_page_addon_categories_start and dlm_page_addon_categories_end.
* Tweak: Added various filters to filter downloads on all PA pages.
* Tweak: Added Polish translation 

#### 1.2.5: May 17, 2017
* Tweak: Added get_page_id() method to retrieve current page ID in code.
* Tweak: Extension version improvements.

#### 1.2.4: December 3, 2015
* Adding wp_reset_postdata() to reset main post object after custom queries to prevent conflicts with other plugins relying on main post object

#### 1.2.3: November 10, 2015
* Added actions: dlm_page_addon_single_article_start and dlm_page_addon_single_article_end
* Made categories filterable via dlm_page_addon_categories

#### 1.2.2: October 20, 2015
* Tweak: Fixed issue when loading default Download Monitor templates.

#### 1.2.1: October 9, 2015
* Tweak: Fixed a bug that prevented sub-categories to be used in the shortcode attribute: include_categories.

#### 1.2.0: September 4, 2015
* Replaced Page Addon template loader with Download Monitor global template loader.
* Added URL of main page addon page to search form action.
* Added 'dlm_page_addon_before_download_page' action.

#### 1.1.7: July 15, 2015
* Use version date instead of download date on detail page.
* Added Spanish translation, props Josué Díaz.

#### 1.1.6: April 16, 2015
* Fixed a download button error.

#### 1.1.5: April 9, 2015
* Added filter: dlm_page_addon_download_button.

#### 1.1.4: January 8, 2015
* Compatibility with Download Monitor 1.6
* Use new extension API.

#### 1.1.3: January 7, 2015
* Compatibility with Download Monitor 1.6
* Use new extension API.

#### 1.1.2: January 1, 2013
* child_of for category wp_list_filter
* Textdomain fixes
* relevanssi workarounds

#### 1.1.1: January 1, 2013
* Fix download links with default permalinks

#### 1.1.1: January 1, 2013
* include_categories and exclude_categories option accepts comma separated list of ids
* limit tags to maxmimum of 50
* No results template.

#### 1.0.4: January 1, 2013
* Show parent cats when children have downloads

#### 1.0.3: January 1, 2013
* Made search compatible with default permalinks

#### 1.0.2: January 1, 2013
* Search downloads localisation fix
* Removed right arrow from links as it causes localisation issues

#### 1.0.1: January 1, 2013
* Clearfix for categories

#### 1.0.0: January 1, 2013
* First release.