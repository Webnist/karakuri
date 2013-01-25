<?php

// Prevent loading this file directly - Busted!
if ( !defined('ABSPATH') )
	die('-1');

if ( ! class_exists( 'WPGitHubThemeUpdater' ) ) :

/**
 * @version 1.4
 * @author Joachim Kudish <info@jkudish.com>
 * @link http://jkudish.com
 * @package GithubUpdater
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright (c) 2011, Joachim Kudish
 *
 * GNU General Public License, Free Software Foundation
 * <http://creativecommons.org/licenses/GPL/2.0/>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not,  write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
class WPGitHubThemeUpdater {

	/**
	 * Class Constructor
	 *
	 * @since 1.0
	 * @param array $config configuration
	 * @return void
	 */
	public function __construct( $config = array() ) {

		global $wp_version;

		$defaults = array(
			'slug' => $this->theme_basename(__FILE__),
			'proper_folder_name' => dirname( plugin_basename(__FILE__) ),
			'api_url' => 'https://api.github.com/repos/Webnist/karakuri',
			'raw_url' => 'https://raw.github.com/Webnist/karakuri/master',
			'github_url' => 'https://raw.github.com/Webnist/karakuri',
			'zip_url' => 'https://raw.github.com/Webnist/karakuri/zipball/master',
			'sslverify' => true,
			'requires' => $wp_version,
			'tested' => $wp_version
		);

		$this->config = wp_parse_args( $config, $defaults );

		$this->set_defaults();

		if ( ( defined('WP_DEBUG') && WP_DEBUG ) || ( defined('WP_GITHUB_FORCE_UPDATE') || WP_GITHUB_FORCE_UPDATE ) )
			add_action( 'init', array( $this, 'delete_transients' ) );

		add_filter( 'pre_set_site_transient_update_themes',  array( $this, 'api_check' ) );

		// Hook into the plugin details screen
		add_filter( 'themes_api', array( $this, 'get_theme_info' ), 10, 3 );
		add_filter( 'upgrader_post_install', array( $this, 'upgrader_post_install' ), 11, 3 );

		// set timeout
		add_filter( 'http_request_timeout', array( $this, 'http_request_timeout' ) );
	}


	/**
	 * Set defaults
	 *
	 * @since 1.2
	 * @return void
	 */
	public function set_defaults() {

		if ( ! isset( $this->config['new_version'] ) )
			$this->config['new_version'] = $this->get_new_version();

		if ( ! isset( $this->config['last_updated'] ) )
			$this->config['last_updated'] = $this->get_date();

		if ( ! isset( $this->config['description'] ) )
			$this->config['description'] = $this->get_description();

		$theme_data = $this->get_theme_data();
		if ( ! isset( $this->config['theme_name'] ) )
			$this->config['theme_name'] = $theme_data['Name'];

		if ( ! isset( $this->config['version'] ) )
			$this->config['version'] = $theme_data['Version'];

		if ( ! isset( $this->config['author'] ) )
			$this->config['author'] = $theme_data['Author'];

		if ( ! isset( $this->config['homepage'] ) )
			$this->config['homepage'] = $theme_data['themeURI'];
		if ( ! isset( $this->config['readme'] ) )
			$this->config['readme'] = 'README.md';
	}

	/**
	 * Get theme basename
	 *
	 *@since 1.0
	 *@return basename of the theme
	 */
	public function theme_basename($theme = __FILE__){
		return trim(str_replace(WP_CONTENT_DIR.'/themes', '', dirname(__FILE__)), '/');
	}

	/**
	 * Callback fn for the http_request_timeout filter
	 *
	 * @since 1.0
	 * @return int timeout value
	 */
	public function http_request_timeout() {
		return 2;
	}


	/**
	 * Delete transients (runs when WP_DEBUG is on)
	 * For testing purposes the site transient will be reset on each page load
	 *
	 * @since 1.0
	 * @return void
	 */
	public function delete_transients() {
		delete_site_transient( 'update_plugins' );
		delete_site_transient( $this->config['slug'].'_new_version' );
		delete_site_transient( $this->config['slug'].'_github_data' );
		delete_site_transient( $this->config['slug'].'_changelog' );
	}


	/**
	 * Get New Version from github
	 *
	 * @since 1.0
	 * @return int $version the version number
	 */
	public function get_new_version() {

		$version = get_site_transient( $this->config['slug'].'_new_version' );

		if ( !isset( $version ) || !$version || '' == $version ) {

			$raw_response = wp_remote_get( $this->config['raw_url'], array('sslverify' => $this->config['sslverify'],));

			if ( is_wp_error( $raw_response ) )
				return false;

			preg_match('#^\s*Version\:\s*(.*)$#im', $raw_response['body'], $matches);

			if(empty($matches[1]))
				return false;

			$version = $matches[1];
			// refresh every 6 hours
			set_site_transient( $this->config['slug'].'_new_version', $version, 60*60*6 );
		}

		return $version;
	}


	/**
	 * Get GitHub Data from the specified repository
	 *
	 * @since 1.0
	 * @return array $github_data the data
	 */
	public function get_github_data() {
		$github_data = get_site_transient( $this->config['slug'].'_github_data' );

		if ( ! isset( $github_data ) || ! $github_data || '' == $github_data ) {
			$github_data = wp_remote_get($this->config['api_url'], $this->config['sslverify']);

			if ( is_wp_error( $github_data ) )
				return false;

			$github_data = json_decode( $github_data['body'] );

			// refresh every 6 hours
			set_site_transient( $this->config['slug'].'_github_data', $github_data, 60*60*6);
		}

		return $github_data;
	}


	/**
	 * Get update date
	 *
	 * @since 1.0
	 * @return string $date the date
	 */
	public function get_date() {
		$_date = $this->get_github_data();
		return ( !empty($_date->updated_at) ) ? date( 'Y-m-d', strtotime( $_date->updated_at ) ) : false;
	}


	/**
	 * Get plugin description
	 *
	 * @since 1.0
	 * @return string $description the description
	 */
	public function get_description() {
		$_description = $this->get_github_data();
		return ( !empty($_description->description) ) ? $_description->description : false;
	}


	/**
	 * Get Plugin data
	 *
	 * @since 1.0
	 * @return object $data the data
	 */
	public function get_theme_data() {
		include_once( ABSPATH.'/wp-admin/includes/theme.php' );
		$data = wp_get_theme();
		return $data;
	}


	/**
	 * Hook into the plugin update check and connect to github
	 *
	 * @since 1.0
	 * @param object $transient the plugin data transient
	 * @return object $transient updated plugin data transient
	 */
	public function api_check( $transient ) {
		// Check if the transient contains the 'checked' information
		// If not, just return its value without hacking it
		if ( empty( $transient->checked ) )
			return $transient;

		// check the version and decide if it's new
		$update = version_compare( $this->config['new_version'], $this->config['version'] );

		if ( 1 === $update ) {
			$response = array();
			$response['new_version'] = $this->config['new_version'];
			$response['slug'] = $this->config['proper_folder_name'];
			$response['url'] = $this->config['github_url'];
			$response['package'] = $this->config['zip_url'];

			// If response is false, don't alter the transient
			if ( false !== $response )
				$transient->response[ $this->config['slug'] ] = $response;
		}
		return $transient;
	}


	/**
	 * Get Theme info
	 *
	 * @since 1.0
	 * @param bool $false always false
	 * @param string $action the API function being performed
	 * @param object $args theme arguments
	 * @return object $response the theme info
	 */
	public function get_theme_info( $false,
 $action,
 $response ) {

		// Check if this call API is for the right theme
		if ( $response->slug != $this->config['slug'] )
			return false;

		$response->slug = $this->config['slug'];
		$response->theme_name  = $this->config['theme_name'];
		$response->version = $this->config['new_version'];
		$response->author = $this->config['author'];
		$response->homepage = $this->config['homepage'];
		$response->requires = $this->config['requires'];
		$response->tested = $this->config['tested'];
		$response->downloaded   = 0;
		$response->last_updated = $this->config['last_updated'];
		$response->sections = array( 'description' => $this->config['description'] );
		$response->download_link = $this->config['zip_url'];

		return $response;
	}


	/**
	 * Upgrader/Updater
	 * Move & activate the theme, echo the update message
	 *
	 * @since 1.0
	 * @param boolean $true always true
	 * @param mixed $hook_extra not used
	 * @param array $result the result of the move
	 * @return array $result the result of the move
	 */
	public function upgrader_post_install( $true, $hook_extra, $result ) {

		global $wp_filesystem;

		// Move & Activate
		$proper_destination = WP_CONTENT_DIR.'/themes/'.$this->config['proper_folder_name'].'/';
		$wp_filesystem->move( $result['destination'], $proper_destination );
		$result['destination'] = $proper_destination;
		$result['destination_name'] = $this->config['proper_folder_name'];
		$result['remote_destination'] = $proper_destination;
		$activate = switch_theme( $this->config['slug'], $this->config['slug'] );
		return $result;

	}

}

endif; // endif class exists