{
  "properties": {
    "version": "6.7.2",
    "release_timestamp": 1527681600,
    "slug_parent": "icwp",
    "slug_plugin": "wpsf",
    "human_name": "Shield",
    "menu_title": "Shield",
    "text_domain": "wp-simple-firewall",
    "base_permissions": "manage_options",
    "wpms_network_admin_only": true,
    "logging_enabled": true,
    "show_dashboard_widget": true,
    "autoupdate": "confidence",
    "autoupdate_days": 3,
    "options_encoding": "json",
    "enable_premium": true
  },
  "requirements": {
    "php": "5.2.4",
    "wordpress": "3.5.0"
  },
  "paths": {
    "source": "src",
    "assets": "resources",
    "languages": "languages",
    "templates": "templates",
    "flags": "flags"
  },
  "includes": {
    "admin": {
      "css": [
        "global-plugin",
        "featherlight"
      ],
      "js": [
        "global-plugin",
        "featherlight"
      ]
    },
    "plugin_admin": {
      "css": [
        "bootstrap4",
        "plugin"
      ],
      "js": [
        "bootstrap4.bundle.min",
        "plugin"
      ]
    },
    "frontend": {
      "css": null
    }
  },
  "menu": {
    "show": true,
    "title": "Shield Security",
    "top_level": true,
    "do_submenu_fix": true,
    "callback": "onDisplayTopMenu",
    "icon_image": "pluginlogo_16x16.png",
    "has_submenu": true
  },
  "labels": {
    "Name": "Shield",
    "Description": "Ultimate Security For Your Sites With The Highest Rated WordPress Security Plugin",
    "Title": "Shield Security",
    "Author": "One Dollar Plugin",
    "AuthorName": "One Dollar Plugin",
    "PluginURI": "http://icwp.io/2f",
    "AuthorURI": "http://icwp.io/bv",
    "icon_url_16x16": "pluginlogo_16x16.png",
    "icon_url_32x32": "pluginlogo_32x32.png"
  },
  "plugin_meta": [
    {
      "name": "5&#10025; Rate This Plugin",
      "href": "http://icwp.io/wpsf29"
    }
  ],
  "action_links": {
    "remove": null,
    "add": [
      {
        "name": "Dashboard",
        "url_method_name": "getPluginUrl_AdminMainPage"
      }
    ]
  }
}