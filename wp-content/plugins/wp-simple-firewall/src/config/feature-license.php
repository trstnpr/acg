{
  "slug": "license",
  "properties": {
    "slug": "license",
    "name": "Shield Pro",
    "tagline": "The Best In WordPress Security, Only Better.",
    "auto_enabled": true,
    "show_module_menu_item": true,
    "highlight_menu_item": true,
    "storage_key": "license",
    "show_central": false,
    "premium": false,
    "access_restricted": true
  },
  "sections": [
    {
      "slug": "section_license_options",
      "title": "License Options",
      "primary": true
    },
    {
      "slug": "section_non_ui",
      "hidden": true
    }
  ],
  "options": [
    {
      "key": "license_key",
      "sensitive": true,
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "license_activated_at",
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_deactivated_at",
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_last_checked_at",
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_last_request_at",
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_verified_at",
      "sensitive": true,
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_expires_at",
      "sensitive": true,
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "license_official_status",
      "sensitive": true,
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "license_deactivated_reason",
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "license_registered_email",
      "sensitive": true,
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "is_shield_central",
      "sensitive": true,
      "transferable": false,
      "default": false,
      "section": "section_non_ui"
    },
    {
      "key": "last_errors",
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "last_error_at",
      "sensitive": true,
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    },
    {
      "key": "keyless_request_hash",
      "sensitive": true,
      "transferable": false,
      "default": "",
      "section": "section_non_ui"
    },
    {
      "key": "keyless_request_at",
      "sensitive": true,
      "transferable": false,
      "default": 0,
      "section": "section_non_ui"
    }
  ],
  "definitions": {
    "license_store_url": "https://onedollarplugin.com/edd-sl/",
    "keyless_cp": "http://icwp.io/c5",
    "license_item_name": "Shield Security Pro",
    "license_item_id": "6047",
    "license_item_name_sc": "Shield Security Pro (via Shield Central)",
    "license_item_id_sc": "968",
    "lic_verify_expire_days": 3,
    "lic_verify_expire_grace_days": 1,
    "license_key_length": 32,
    "license_key_type": "alphanumeric",
    "keyless": true,
    "keyless_handshake_expire": 90
  }
}