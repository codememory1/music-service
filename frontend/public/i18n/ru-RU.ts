export default {
  buttons: {
    prev: 'Previous',
    next: 'Next',
    register: 'Register',
    login: 'Login',
    send_code: 'Send Code',
    add: 'Add',
    create: 'Create',
    update: 'Update',
    reset: 'Reset',
    buy_subscription: 'Buy a subscription',
    restore_password: 'Restore password'
  },

  placeholder: {
    enter_pseudonym: 'Enter your Pseudonym',
    enter_email: 'Enter your Email',
    enter_password: 'Enter your Password',
    enter_confirm_password: 'Enter password confirmation',
    enter_playlist_directory_title: 'Enter directory name',
    select_type: 'Select type',
    enter_multimedia_title: 'Enter multimedia title',
    enter_multimedia_description: 'Enter multimedia description',
    enter_multimedia_text: 'Enter original media text',
    enter_multimedia_producer: 'Enter media producer',
    select_multimedia_genre: 'Select multimedia genre',
    select_album: 'Select album',
    select_multimedia_performers: 'Select media contributors',
    choose_media_file: 'Choose a media file',
    choose_image_file: 'Choose image file',
    choose_subtitle_file: 'Choose a subtitle file',
    is_obscene_words: 'Is there profanity in the media?',
    search: 'Search...',
    enter_album_title: 'Enter album title',
    enter_album_description: 'Enter album description',
    enter_playlist_title: 'Enter playlist title',
    choose_lang: 'Choose language'
  },

  modal: {
    titles: {
      register: 'Registration',
      auth: 'Authorization',
      password_recovery: 'Password Recovery',
      create_playlist_directory: 'Creating a playlist directory',
      update_playlist_directory: 'Update a playlist directory',
      add_multimedia: 'Adding multimedia',
      create_album: 'Create a album',
      create_playlist: 'Create a playlist',
      update_multimedia: 'Update a multimedia',
      password_reset: 'Password Reset'
    },
    switch: {
      have_an_account: 'Have an account?',
      dont_have_account: "Don't know how to account?",
      forgot_your_password: 'Forgot your password?'
    }
  },

  confirm_action: {
    register:
      'By clicking "Register" or registering through a third party, you accept <a href="{terms_use_link}">the {title} terms of use</a> and accept <a href="{privacy_policy_link}">the Privacy Policy</a>.'
  },

  or_via_social_network: 'or via social network',

  alert: {
    titles: {
      upload_files: 'Upload file'
    },
    messages: {
      unable_add_file_max_number:
        'Unable to add file! Maximum number of uploaded files {max_files}',
      unable_add_file_min_size:
        'Unable to add file! Unable to add file! The minimum file size must be {size}{unit}',
      unable_add_file_max_size: 'Unable to add file! File size should not exceed {size}{unit}',
      unable_add_file_not_allowed_mime_type:
        'Unable to add file! Incorrect file mime-type, allowed mime-types: {mime_types}'
    }
  },

  steep_form: {
    multimedia: {
      type: 'Multimedia type definition',
      basic_info: 'Basic information',
      secondary_info: 'Secondary Information',
      members: 'Participant settings'
    },
    album: {
      type: 'Album type definition',
      basic_info: 'Basic information'
    }
  },

  drag_and_drop: {
    click_to_upload: 'Click to upload',
    or_drag_and_drop: 'or drag and drop'
  },

  no_matches_found: 'No matches found',

  multimedia: {
    type: {
      track: 'Music',
      clip: 'Clip'
    }
  },

  section: {
    our_advantage: {
      title: 'Our advantages',
      items: {
        unique_features: {
          title: 'Unique features',
          description: 'Lots of unique features for your use.'
        },
        subscription_price: {
          title: 'Subscription price',
          description: 'Low prices for extended list of subscriptions.'
        },

        more_options_for_free_subscription: {
          title: 'More options for free subscription',
          description: 'Lots of features for free use.'
        },

        listen_to_opinions_users: {
          title: 'We listen to the opinions of users',
          description: 'We listen to your opinion on the implementation of new functionality.'
        },

        ease_use: {
          title: 'Ease of use',
          description: 'Use all the features of the platform with convenience.'
        },

        stream_control: {
          title: 'Stream control',
          description: 'Control media flow if you have poor internet.'
        }
      }
    },

    subscription: {
      title: 'Choose your subscription',
      description: 'Listen without limits on your phone, speaker and other devices'
    }
  },

  hero: {
    home: {
      header: 'Listening is everything in your life',
      tagline:
        'Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card.'
    }
  },

  footer: {
    main: {
      rows: {
        get_started: {
          title: 'Get Started',
          items: {
            pricing_and_plans: 'Pricing & Plans',
            get_support: 'Get Support'
          }
        },
        discover: {
          title: 'Discover',
          items: {
            about: 'About',
            explore_the_app: 'Explore the App',
            for_artists: 'For Artists'
          }
        },
        company: {
          title: 'Company',
          items: {
            partners: 'Partners',
            careers: 'Careers',
            guarantee: 'Guarantee',
            contacts: 'Contact Information'
          }
        },
        community: {
          title: 'Community',
          items: {
            changelog: "What's new ?",
            suggestion: 'Suggestion',
            api: 'API',
            ads: 'Ads'
          }
        }
      }
    },

    bottom_links: {
      privacy_policy: 'Privacy Policy',
      terms_and_conditions: 'Terms and Conditions',
      cookie_settings: 'Cookie Settings',
      sitemap: 'Sitemap'
    }
  },

  navigation: {
    main: {
      premium: 'Premium',
      support: 'Support',
      signUp: 'Sign Up',
      signIn: 'Sign In'
    }
  }
};
