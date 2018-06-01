{
  "slug": "user_management",
  "properties": {
    "name": "User Management",
    "show_module_menu_item": true,
    "storage_key": "user_management",
    "tagline": "Control user sessions, duration, timeouts and account sharing",
    "show_central": true,
    "access_restricted": true,
    "premium": false,
    "has_custom_actions": true,
    "order": 40
  },
  "sections": [
    {
      "slug": "section_user_session_management",
      "primary": true,
      "primary": true,
      "title": "User Session Management",
      "title_short": "Session Options",
      "summary": [
        "Purpose - Allows you to better control user sessions on your site and expire idle sessions and prevent account sharing.",
        "Recommendation - Use of this feature is highly recommend."
      ]
    },
    {
      "slug": "section_passwords",
      "reqs" : {
        "php_min": "5.4"
      },
      "title": "Password Policies",
      "title_short": "Password Policies",
      "summary": [
        "Purpose - Have full control over passwords used by users on the site.",
        "Recommendation - Use of this feature is highly recommend."
      ]
    },
    {
      "slug": "section_admin_login_notification",
      "title": "Admin Login Notification",
      "title_short": "Notifications",
      "summary": [
        "Purpose - So you can be made aware of when a WordPress administrator has logged into your site when you are not expecting it.",
        "Recommendation - Use of this feature is highly recommend."
      ]
    },
    {
      "slug": "section_enable_plugin_feature_user_accounts_management",
      "title": "Enable Module: User Management",
      "title_short": "Disable Module",
      "summary": [
        "Purpose - User Management offers real user sessions, finer control over user session time-out, and ensures users have logged-in in a correct manner.",
        "Recommendation - Keep the User Management feature turned on."
      ]
    },
    {
      "slug": "section_non_ui",
      "hidden": true
    }
  ],
  "options": [
    {
      "key": "enable_user_management",
      "section": "section_enable_plugin_feature_user_accounts_management",
      "default": "Y",
      "type": "checkbox",
      "link_info": "",
      "link_blog": "",
      "name": "Enable User Management",
      "summary": "Enable (or Disable) The User Management module",
      "description": "Un-Checking this option will completely disable the User Management module"
    },
    {
      "key": "enable_admin_login_email_notification",
      "section": "section_admin_login_notification",
      "sensitive": true,
      "default": "",
      "type": "email",
      "link_info": "",
      "link_blog": "",
      "name": "Admin Login Notification Email",
      "summary": "Send An Notification Email When Administrator Logs In",
      "description": "If you would like to be notified every time an administrator user logs into this WordPress site, enter a notification email address. No email address - No Notification."
    },
    {
      "key": "session_timeout_interval",
      "section": "section_user_session_management",
      "default": 2,
      "type": "integer",
      "link_info": "",
      "link_blog": "",
      "name": "Session Timeout",
      "summary": "Specify How Many Days After Login To Automatically Force Re-Login",
      "description": "WordPress default is 2 days, or 14 days if you check the 'Remember Me' box."
    },
    {
      "key": "session_idle_timeout_interval",
      "section": "section_user_session_management",
      "default": 0,
      "type": "integer",
      "link_info": "",
      "link_blog": "",
      "name": "Idle Timeout",
      "summary": "Specify How Many Hours After Inactivity To Automatically Logout User",
      "description": "If the user is inactive for the number of hours specified, they will be forcefully logged out next time they return. Set this to '0' to turn off this option."
    },
    {
      "key": "session_lock_location",
      "section": "section_user_session_management",
      "default": "N",
      "type": "checkbox",
      "link_info": "",
      "link_blog": "",
      "name": "Lock To Location",
      "summary": "Locks A User Session To IP address",
      "description": "When selected, a session is restricted to the same IP address as when the user logged in. If a logged-in user's IP address changes, the session will be invalidated and they'll be forced to re-login to WordPress."
    },
    {
      "key": "session_username_concurrent_limit",
      "section": "section_user_session_management",
      "default": 0,
      "type": "integer",
      "link_info": "",
      "link_blog": "",
      "name": "Max Simultaneous Sessions",
      "summary": "Limit Simultaneous Sessions For The Same Username",
      "description": "The number provided here is the maximum number of simultaneous, distinct, sessions allowed for any given username. Use '0' for no limits."
    },
    {
      "key": "enable_password_policies",
      "section": "section_passwords",
      "type": "checkbox",
      "default": "N",
      "link_info": "http://icwp.io/c4",
      "link_blog": "",
      "name": "Enable Password Policies",
      "summary": "Enable The Password Policies Below",
      "description": "Turn on/off all password policies."
    },
    {
      "key": "pass_prevent_pwned",
      "section": "section_passwords",
      "type": "checkbox",
      "default": "Y",
      "link_info": "http://icwp.io/by",
      "link_blog": "",
      "name": "Prevent Pwned Passwords",
      "summary": "Prevent Use Of Pwned Passwords",
      "description": "Prevents users from using any passwords found on the public available list of pwned passwords."
    },
    {
      "key": "pass_min_length",
      "premium": true,
      "section": "section_passwords",
      "premium": true,
      "type": "integer",
      "default": "12",
      "link_info": "",
      "link_blog": "",
      "name": "Minimum Length",
      "summary": "Minimum Password Length",
      "description": "All passwords that a user sets must be at least this many characters in length."
    },
    {
      "key": "pass_min_strength",
      "premium": true,
      "section": "section_passwords",
      "premium": true,
      "type":          "select",
      "default": "4",
      "value_options": [
        {
          "value_key": "0",
          "text":      "Very Weak"
        },
        {
          "value_key": "1",
          "text":      "Weak"
        },
        {
          "value_key": "2",
          "text":      "Medium"
        },
        {
          "value_key": "3",
          "text":      "Strong"
        },
        {
          "value_key": "4",
          "text":      "Very Strong"
        }
      ],
      "link_info": "",
      "link_blog": "",
      "name": "Minimum Strength",
      "summary": "Minimum Password Strength",
      "description": "All passwords that a user sets must meet this minimum strength."
    },
    {
      "key": "pass_force_existing",
      "premium": true,
      "section": "section_passwords",
      "premium": true,
      "type": "checkbox",
      "default": "N",
      "link_info": "",
      "link_blog": "",
      "name": "Apply To Existing Users",
      "summary": "Apply Password Policies To Existing Users and Their Passwords",
      "description": "Forces existing users to update their passwords if they don't meet requirements, after they next login ."
    },
    {
      "key": "pass_expire",
      "premium": true,
      "section": "section_passwords",
      "premium": true,
      "type": "integer",
      "default": "60",
      "link_info": "",
      "link_blog": "",
      "name": "Password Expiration",
      "summary": "Passwords Expire After This Many Days",
      "description": "Users will be forced to reset their passwords after the number of days specified."
    },
    {
      "key":          "autoadd_sessions_started_at",
      "transferable": false,
      "section":      "section_non_ui"
    },
    {
      "key":          "insights_last_idle_logout_at",
      "transferable": false,
      "section":      "section_non_ui",
      "default":      0
    },
    {
      "key":          "insights_last_password_block_at",
      "transferable": false,
      "section":      "section_non_ui",
      "default":      0
    }
  ],
  "definitions": {
    "pwned_api_url_password_single": "https://api.pwnedpasswords.com/pwnedpassword/",
    "pwned_api_url_password_range": "https://api.pwnedpasswords.com/range/"
  }
}