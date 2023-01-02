export default {
  buttons: {
    prev: 'Previous',
    next: 'Next',
    register: 'Register',
    login: 'Login',
    send_code: 'Send Code',
    add: 'Add',
    create: 'Create',
    update: 'Update'
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
    enter_playlist_title: 'Enter playlist title'
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
      update_multimedia: 'Update a multimedia'
    },
    switch: {
      have_an_account: 'Have an account?',
      dont_have_account: "Don't know how to account?"
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
  }
};
