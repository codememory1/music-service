import { ApiRoute } from '~/api/ApiRoute';
import { EnumRequestMethods } from '~/Enums/EnumRequestMethods';

export default {
  lang: {
    all: new ApiRoute('/language/all', EnumRequestMethods.Get, [], ['code', 'title'])
  },

  security: {
    register: new ApiRoute('/user/register', EnumRequestMethods.Post),
    auth: new ApiRoute('/user/auth', EnumRequestMethods.Post),
    update_access_token: new ApiRoute('/user/access-token/update', EnumRequestMethods.Put),
    logout: new ApiRoute('/user/logout'),
    account_activation: new ApiRoute('/user/account-activation', EnumRequestMethods.Post),

    password_reset: {
      request_restoration: new ApiRoute(
        '/user/password-reset/request-restoration',
        EnumRequestMethods.Post
      ),
      restore: new ApiRoute('/user/password-reset/restore-password', EnumRequestMethods.Post)
    }
  },

  subscription: {
    all: new ApiRoute('/subscription/all')
  },

  album: {
    all: new ApiRoute('/album/all'),
    create: new ApiRoute('/album/create', EnumRequestMethods.Post),
    publish: (id: number) => new ApiRoute(`/album/${id}/publish`, EnumRequestMethods.Patch),
    update: (id: number) => new ApiRoute(`/album/${id}/edit`, EnumRequestMethods.Put),
    delete: (id: number) => new ApiRoute(`/album/${id}/delete`, EnumRequestMethods.Delete)
  },

  user_session: {
    all: new ApiRoute(
      '/user/session/all',
      EnumRequestMethods.Get,
      ['isActive'],
      ['createdAt', 'lastActivity', 'country', 'city']
    ),
    delete: (id: number) => new ApiRoute(`/user/session/${id}/delete`, EnumRequestMethods.Delete),
    delete_all_active: new ApiRoute('/user/session/all/delete', EnumRequestMethods.Delete)
  },

  social_auth: {
    google: {
      url_auth: new ApiRoute('/user/google/authorization-url'),
      auth: new ApiRoute('/user/google/auth', EnumRequestMethods.Post)
    }
  },

  multimedia: {
    category: {
      all: new ApiRoute('/multimedia/category/all')
    },

    all_my: new ApiRoute(
      '/album/all',
      EnumRequestMethods.Get,
      ['type'],
      ['title', 'createdAt', 'duration', 'auditions', 'like']
    ),
    all_by_user: (id: number) =>
      new ApiRoute(
        `/user/${id}/multimedia/all`,
        EnumRequestMethods.Get,
        ['type'],
        ['title', 'createdAt', 'duration', 'auditions', 'like']
      ),
    statistics: (id: number) => new ApiRoute(`/user/multimedia/${id}/statistics`),
    add: new ApiRoute('/user/multimedia/add', EnumRequestMethods.Post),
    update: (id: number) => new ApiRoute(`/user/multimedia/${id}/edit`, EnumRequestMethods.Put),
    delete: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/delete`, EnumRequestMethods.Delete),
    like: (id: number) => new ApiRoute(`/user/multimedia/${id}/like`, EnumRequestMethods.Patch),
    dislike: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/dislike`, EnumRequestMethods.Patch),
    send_on_moderation: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/send-on-moderation`, EnumRequestMethods.Patch),
    send_on_appeal: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/send-on-appeal`, EnumRequestMethods.Patch),
    add_to_media_library: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/add-to-media-library`, EnumRequestMethods.Post),
    play_pause: (id: number) =>
      new ApiRoute(`/user/multimedia/${id}/play-pause`, EnumRequestMethods.Patch),

    time_code: {
      add: (id: number) =>
        new ApiRoute(`/user/multimedia/${id}/time-code/add`, EnumRequestMethods.Post),
      delete: (id: number) =>
        new ApiRoute(`/user/multimedia/time-code/${id}/delete`, EnumRequestMethods.Delete)
    }
  },

  artist: {
    subscribe: (id: number) => new ApiRoute(`/artist/${id}/subscribe`, EnumRequestMethods.Patch),
    unsubscribe: (id: number) => new ApiRoute(`/artist/${id}/unsubscribe`, EnumRequestMethods.Patch)
  },

  media_library: {
    all: new ApiRoute('/user/media-library/multimedia/all'),
    statistics: new ApiRoute('/user/media-library/statistic'),

    multimedia: {
      share: (multimediaId: number, friendId: number) =>
        new ApiRoute(
          `/user/media-library/multimedia/${multimediaId}/share/with-friend/${friendId}`,
          EnumRequestMethods.Patch
        ),
      update: (id: number) =>
        new ApiRoute(`/user/media-library/multimedia/${id}/edit`, EnumRequestMethods.Put),
      delete: (id: number) =>
        new ApiRoute(`/user/media-library/multimedia/${id}/delete`, EnumRequestMethods.Delete),

      event: {
        add: (id: number) =>
          new ApiRoute(`/user/media-library/multimedia/${id}/event/add`, EnumRequestMethods.Post),
        update: (id: number) =>
          new ApiRoute(`/user/media-library/multimedia/event/${id}/edit`, EnumRequestMethods.Put),
        delete: (id: number) =>
          new ApiRoute(
            `/user/media-library/multimedia/event/${id}/delete`,
            EnumRequestMethods.Delete
          )
      }
    },

    event: {
      add: new ApiRoute('/user/media-library/event/add', EnumRequestMethods.Post),
      update: (id: number) =>
        new ApiRoute(`/user/media-library/event/${id}/edit`, EnumRequestMethods.Put),
      delete: (id: number) =>
        new ApiRoute(`/user/media-library/event/${id}/delete`, EnumRequestMethods.Delete)
    }
  },

  playlist: {
    all: new ApiRoute(
      '/user/media-library/playlist/all',
      EnumRequestMethods.Get,
      ['title'],
      ['title', 'createdAt', 'numberMultimedia']
    ),
    read: (id: number) => new ApiRoute(`/user/media-library/playlist/${id}/read`),
    create: new ApiRoute('/user/media-library/playlist/create', EnumRequestMethods.Post),
    update: (id: number) =>
      new ApiRoute(`/user/media-library/playlist/${id}/edit`, EnumRequestMethods.Put),
    delete: (id: number) =>
      new ApiRoute(`/user/media-library/playlist/${id}/delete`, EnumRequestMethods.Delete),

    multimedia: {
      move_to_directory: (multimediaId: number, directoryId: number) =>
        new ApiRoute(
          `/user/media-library/playlist/multimedia/${multimediaId}/move/directory/${directoryId}`,
          EnumRequestMethods.Put
        )
    },

    directory: {
      create: (id: number) =>
        new ApiRoute(
          `/user/media-library/playlist/${id}/directory/create`,
          EnumRequestMethods.Post
        ),
      update: (id: number) =>
        new ApiRoute(`/user/media-library/playlist/directory/${id}/edit`, EnumRequestMethods.Put),
      delete: (id: number) =>
        new ApiRoute(
          `/user/media-library/playlist/directory/${id}/delete`,
          EnumRequestMethods.Delete
        ),

      multimedia: {
        add: (directoryId: number, multimediaId: number) =>
          new ApiRoute(
            `/user/media-library/playlist/directory/${directoryId}/multimedia/${multimediaId}/add`,
            EnumRequestMethods.Post
          ),
        delete: (id: number) =>
          new ApiRoute(
            `/user/media-library/playlist/directory/multimedia/${id}/delete`,
            EnumRequestMethods.Delete
          )
      }
    }
  },

  user: {
    profile: {
      update_design: new ApiRoute('/user/profile/design/edit', EnumRequestMethods.Put)
    }
  },

  friend: {
    all: new ApiRoute('/user/friend/all', EnumRequestMethods.Get, [], ['date', 'acceptFriendship']),
    add: (id: number) => new ApiRoute(`/user/${id}/add-as-friend`, EnumRequestMethods.Post),
    accept_application: (id: number) =>
      new ApiRoute(`/user/friend/${id}/accept`, EnumRequestMethods.Patch),
    delete: (id: number) => new ApiRoute(`/user/friend/${id}/delete`, EnumRequestMethods.Delete)
  },

  history: {
    all: new ApiRoute('/user/history/all', EnumRequestMethods.Get, ['now'], ['date']),
    delete: (id: number) =>
      new ApiRoute(`/user/history/listen/${id}/delete`, EnumRequestMethods.Delete)
  }
};
