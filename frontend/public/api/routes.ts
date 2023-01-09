import Route from '~/api/route';
import { HttpRequestMethodEnum } from '~/enums/http-request-method-enum';

export default {
  lang: {
    all: new Route('language/all', HttpRequestMethodEnum.GET, [], ['code', 'title'])
  },

  security: {
    register: new Route('user/register', HttpRequestMethodEnum.POST),
    auth: new Route('user/auth', HttpRequestMethodEnum.POST),
    update_access_token: new Route('user/access-token/update', HttpRequestMethodEnum.PUT),
    logout: new Route('user/logout'),
    account_activation: new Route('user/account-activation', HttpRequestMethodEnum.POST),

    password_reset: {
      request_restoration: new Route(
        '/user/password-reset/request-restoration',
        HttpRequestMethodEnum.POST
      ),
      restore: new Route('user/password-reset/restore-password', HttpRequestMethodEnum.POST)
    }
  },

  subscription: {
    all: new Route('subscription/all')
  },

  album: {
    all: new Route('album/all'),
    create: new Route('album/create', HttpRequestMethodEnum.POST),
    publish: (id: number) => new Route(`album/${id}/publish`, HttpRequestMethodEnum.PATCH),
    update: (id: number) => new Route(`album/${id}/edit`, HttpRequestMethodEnum.PUT),
    delete: (id: number) => new Route(`album/${id}/delete`, HttpRequestMethodEnum.DELETE)
  },

  user_session: {
    all: new Route(
      '/user/session/all',
      HttpRequestMethodEnum.GET,
      ['isActive'],
      ['createdAt', 'lastActivity', 'country', 'city']
    ),
    delete: (id: number) => new Route(`user/session/${id}/delete`, HttpRequestMethodEnum.DELETE),
    delete_all_active: new Route('user/session/all/delete', HttpRequestMethodEnum.DELETE)
  },

  social_auth: {
    google: {
      url_auth: new Route('user/google/authorization-url'),
      auth: new Route('user/google/auth', HttpRequestMethodEnum.POST)
    }
  },

  multimedia: {
    category: {
      all: new Route('multimedia/category/all')
    },

    all_my: new Route(
      '/album/all',
      HttpRequestMethodEnum.GET,
      ['type'],
      ['title', 'createdAt', 'duration', 'auditions', 'like']
    ),
    all_by_user: (id: number) =>
      new Route(
        `/user/${id}/multimedia/all`,
        HttpRequestMethodEnum.GET,
        ['type'],
        ['title', 'createdAt', 'duration', 'auditions', 'like']
      ),
    statistics: (id: number) => new Route(`user/multimedia/${id}/statistics`),
    add: new Route('user/multimedia/add', HttpRequestMethodEnum.POST),
    update: (id: number) => new Route(`user/multimedia/${id}/edit`, HttpRequestMethodEnum.PUT),
    delete: (id: number) => new Route(`user/multimedia/${id}/delete`, HttpRequestMethodEnum.DELETE),
    like: (id: number) => new Route(`user/multimedia/${id}/like`, HttpRequestMethodEnum.PATCH),
    dislike: (id: number) =>
      new Route(`user/multimedia/${id}/dislike`, HttpRequestMethodEnum.PATCH),
    send_on_moderation: (id: number) =>
      new Route(`user/multimedia/${id}/send-on-moderation`, HttpRequestMethodEnum.PATCH),
    send_on_appeal: (id: number) =>
      new Route(`user/multimedia/${id}/send-on-appeal`, HttpRequestMethodEnum.PATCH),
    add_to_media_library: (id: number) =>
      new Route(`user/multimedia/${id}/add-to-media-library`, HttpRequestMethodEnum.POST),
    play_pause: (id: number) =>
      new Route(`user/multimedia/${id}/play-pause`, HttpRequestMethodEnum.PATCH),

    time_code: {
      add: (id: number) =>
        new Route(`user/multimedia/${id}/time-code/add`, HttpRequestMethodEnum.POST),
      delete: (id: number) =>
        new Route(`user/multimedia/time-code/${id}/delete`, HttpRequestMethodEnum.DELETE)
    }
  },

  artist: {
    subscribe: (id: number) => new Route(`artist/${id}/subscribe`, HttpRequestMethodEnum.PATCH),
    unsubscribe: (id: number) => new Route(`artist/${id}/unsubscribe`, HttpRequestMethodEnum.PATCH)
  },

  media_library: {
    all: new Route('user/media-library/multimedia/all'),
    statistics: new Route('user/media-library/statistic'),

    multimedia: {
      share: (multimediaId: number, friendId: number) =>
        new Route(
          `/user/media-library/multimedia/${multimediaId}/share/with-friend/${friendId}`,
          HttpRequestMethodEnum.PATCH
        ),
      update: (id: number) =>
        new Route(`user/media-library/multimedia/${id}/edit`, HttpRequestMethodEnum.PUT),
      delete: (id: number) =>
        new Route(`user/media-library/multimedia/${id}/delete`, HttpRequestMethodEnum.DELETE),

      event: {
        add: (id: number) =>
          new Route(`user/media-library/multimedia/${id}/event/add`, HttpRequestMethodEnum.POST),
        update: (id: number) =>
          new Route(`user/media-library/multimedia/event/${id}/edit`, HttpRequestMethodEnum.PUT),
        delete: (id: number) =>
          new Route(
            `/user/media-library/multimedia/event/${id}/delete`,
            HttpRequestMethodEnum.DELETE
          )
      }
    },

    event: {
      add: new Route('user/media-library/event/add', HttpRequestMethodEnum.POST),
      update: (id: number) =>
        new Route(`user/media-library/event/${id}/edit`, HttpRequestMethodEnum.PUT),
      delete: (id: number) =>
        new Route(`user/media-library/event/${id}/delete`, HttpRequestMethodEnum.DELETE)
    }
  },

  playlist: {
    all: new Route(
      '/user/media-library/playlist/all',
      HttpRequestMethodEnum.GET,
      ['title'],
      ['title', 'createdAt', 'numberMultimedia']
    ),
    read: (id: number) => new Route(`user/media-library/playlist/${id}/read`),
    create: new Route('user/media-library/playlist/create', HttpRequestMethodEnum.POST),
    update: (id: number) =>
      new Route(`user/media-library/playlist/${id}/edit`, HttpRequestMethodEnum.PUT),
    delete: (id: number) =>
      new Route(`user/media-library/playlist/${id}/delete`, HttpRequestMethodEnum.DELETE),

    multimedia: {
      move_to_directory: (multimediaId: number, directoryId: number) =>
        new Route(
          `/user/media-library/playlist/multimedia/${multimediaId}/move/directory/${directoryId}`,
          HttpRequestMethodEnum.PUT
        )
    },

    directory: {
      create: (id: number) =>
        new Route(
          `/user/media-library/playlist/${id}/directory/create`,
          HttpRequestMethodEnum.POST
        ),
      update: (id: number) =>
        new Route(`user/media-library/playlist/directory/${id}/edit`, HttpRequestMethodEnum.PUT),
      delete: (id: number) =>
        new Route(
          `/user/media-library/playlist/directory/${id}/delete`,
          HttpRequestMethodEnum.DELETE
        ),

      multimedia: {
        add: (directoryId: number, multimediaId: number) =>
          new Route(
            `/user/media-library/playlist/directory/${directoryId}/multimedia/${multimediaId}/add`,
            HttpRequestMethodEnum.POST
          ),
        delete: (id: number) =>
          new Route(
            `/user/media-library/playlist/directory/multimedia/${id}/delete`,
            HttpRequestMethodEnum.DELETE
          )
      }
    }
  },

  user: {
    profile: {
      update_design: new Route('user/profile/design/edit', HttpRequestMethodEnum.PUT)
    }
  },

  friend: {
    all: new Route('user/friend/all', HttpRequestMethodEnum.GET, [], ['date', 'acceptFriendship']),
    add: (id: number) => new Route(`user/${id}/add-as-friend`, HttpRequestMethodEnum.POST),
    accept_application: (id: number) =>
      new Route(`user/friend/${id}/accept`, HttpRequestMethodEnum.PATCH),
    delete: (id: number) => new Route(`user/friend/${id}/delete`, HttpRequestMethodEnum.DELETE)
  },

  history: {
    all: new Route('user/history/all', HttpRequestMethodEnum.GET, ['now'], ['date']),
    delete: (id: number) =>
      new Route(`user/history/listen/${id}/delete`, HttpRequestMethodEnum.DELETE)
  }
};
