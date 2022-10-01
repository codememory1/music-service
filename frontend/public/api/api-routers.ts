export default {
  lang: {
    all: '/language/all'
  },

  security: {
    register: '/user/register',
    auth: '/user/auth',
    update_access_token: '/user/access-token/update',
    logout: '/user/logout',
    account_activation: '/user/account-activation',

    password_reset: {
      request_restoration: '/user/password-reset/request-restoration',
      restore: '/user/password-reset/restore-password'
    }
  },

  subscription: {
    all: '/subscription/all'
  },

  album: {
    all: '/album/all',
    create: '/album/create',
    publish: (id: number) => `/album/${id}/publish`,
    update: (id: number) => `/album/${id}/edit`,
    delete: (id: number) => `/album/${id}/delete`
  },

  user_session: {
    all: '/user/session/all',
    delete: (id: number) => `/user/session/${id}/delete`,
    delete_all_active: '/user/session/all/delete'
  },

  social_auth: {
    google: {
      url_auth: '/user/google/authorization-url',
      auth: '/user/google/auth'
    }
  },

  multimedia: {
    category: {
      all: '/multimedia/category/all'
    },

    all: (id?: number) => (undefined === id ? '/album/all' : `/user/${id}/multimedia/all`),
    statistics: (id: number) => `/user/multimedia/${id}/statistics`,
    add: '/user/multimedia/add',
    update: (id: number) => `/user/multimedia/${id}/edit`,
    delete: (id: number) => `/user/multimedia/${id}/delete`,
    like: (id: number) => `/user/multimedia/${id}/like`,
    dislike: (id: number) => `/user/multimedia/${id}/dislike`,
    send_on_moderation: (id: number) => `/user/multimedia/${id}/send-on-moderation`,
    send_on_appeal: (id: number) => `/user/multimedia/${id}/send-on-appeal`,
    add_to_media_library: (id: number) => `/user/multimedia/${id}/add-to-media-library`,
    play_pause: (id: number) => `/user/multimedia/${id}/play-pause`,

    time_code: {
      add: (id: number) => `/user/multimedia/${id}/time-code/add`,
      delete: (id: number) => `/user/multimedia/time-code/${id}/delete`
    }
  },

  artist: {
    subscribe: (id: number) => `/artist/${id}/subscribe`,
    unsubscribe: (id: number) => `/artist/${id}/unsubscribe`
  },

  media_library: {
    all: '/user/media-library/multimedia/all',
    statistics: '/user/media-library/statistic',

    multimedia: {
      share: (multimediaId: number, friendId: number) =>
        `/user/media-library/multimedia/${multimediaId}/share/with-friend/${friendId}`,
      update: (id: number) => `/user/media-library/multimedia/${id}/edit`,
      delete: (id: number) => `/user/media-library/multimedia/${id}/delete`,

      event: {
        add: (id: number) => `/user/media-library/multimedia/${id}/event/add`,
        update: (id: number) => `/user/media-library/multimedia/event/${id}/edit`,
        delete: (id: number) => `/user/media-library/multimedia/event/${id}/delete`
      }
    },

    event: {
      add: '/user/media-library/event/add',
      update: (id: number) => `/user/media-library/event/${id}/edit`,
      delete: (id: number) => `/user/media-library/event/${id}/delete`
    }
  },

  playlist: {
    all: '/user/media-library/playlist/all',
    read: (id: number) => `/user/media-library/playlist/${id}/read`,
    create: '/user/media-library/playlist/create',
    update: (id: number) => `/user/media-library/playlist/${id}/edit`,
    delete: (id: number) => `/user/media-library/playlist/${id}/delete`,

    multimedia: {
      move_to_directory: (multimediaId: number, directoryId: number) =>
        `/user/media-library/playlist/multimedia/${multimediaId}/move/directory/${directoryId}`
    },

    directory: {
      create: (id: number) => `/user/media-library/playlist/${id}/directory/create`,
      update: (id: number) => `/user/media-library/playlist/directory/${id}/edit`,
      delete: (id: number) => `/user/media-library/playlist/directory/${id}/delete`,

      multimedia: {
        add: (directoryId: number, multimediaId: number) =>
          `/user/media-library/playlist/directory/${directoryId}/multimedia/${multimediaId}/add`,
        delete: (id: number) => `/user/media-library/playlist/directory/multimedia/${id}/delete`
      }
    }
  },

  user: {
    profile: {
      update_design: '/user/profile/design/edit'
    }
  },

  friend: {
    all: '/user/friend/all',
    add: (id: number) => `/user/${id}/add-as-friend`,
    accept_application: (id: number) => `/user/friend/${id}/accept`,
    delete: (id: number) => `/user/friend/${id}/delete`
  },

  history: {
    all: '/user/history/all',
    delete: (id: number) => `/user/history/listen/${id}/delete`
  }
};
