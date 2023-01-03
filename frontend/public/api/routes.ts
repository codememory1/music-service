import { Route } from '~/api/route';
import { HttpRequestMethodEnum } from '~/Enums/http-request-method-enum';

export default {
  lang: {
    all: new Route('/language/all', HttpRequestMethodEnum.Get, [], ['code', 'title'])
  },

  security: {
    register: new Route('/user/register', HttpRequestMethodEnum.Post),
    auth: new Route('/user/auth', HttpRequestMethodEnum.Post),
    update_access_token: new Route('/user/access-token/update', HttpRequestMethodEnum.Put),
    logout: new Route('/user/logout'),
    account_activation: new Route('/user/account-activation', HttpRequestMethodEnum.Post),

    password_reset: {
      request_restoration: new Route(
        '/user/password-reset/request-restoration',
        HttpRequestMethodEnum.Post
      ),
      restore: new Route('/user/password-reset/restore-password', HttpRequestMethodEnum.Post)
    }
  },

  subscription: {
    all: new Route('/subscription/all')
  },

  album: {
    all: new Route('/album/all'),
    create: new Route('/album/create', HttpRequestMethodEnum.Post),
    publish: (id: number) => new Route(`/album/${id}/publish`, HttpRequestMethodEnum.Patch),
    update: (id: number) => new Route(`/album/${id}/edit`, HttpRequestMethodEnum.Put),
    delete: (id: number) => new Route(`/album/${id}/delete`, HttpRequestMethodEnum.Delete)
  },

  user_session: {
    all: new Route(
      '/user/session/all',
      HttpRequestMethodEnum.Get,
      ['isActive'],
      ['createdAt', 'lastActivity', 'country', 'city']
    ),
    delete: (id: number) => new Route(`/user/session/${id}/delete`, HttpRequestMethodEnum.Delete),
    delete_all_active: new Route('/user/session/all/delete', HttpRequestMethodEnum.Delete)
  },

  social_auth: {
    google: {
      url_auth: new Route('/user/google/authorization-url'),
      auth: new Route('/user/google/auth', HttpRequestMethodEnum.Post)
    }
  },

  multimedia: {
    category: {
      all: new Route('/multimedia/category/all')
    },

    all_my: new Route(
      '/album/all',
      HttpRequestMethodEnum.Get,
      ['type'],
      ['title', 'createdAt', 'duration', 'auditions', 'like']
    ),
    all_by_user: (id: number) =>
      new Route(
        `/user/${id}/multimedia/all`,
        HttpRequestMethodEnum.Get,
        ['type'],
        ['title', 'createdAt', 'duration', 'auditions', 'like']
      ),
    statistics: (id: number) => new Route(`/user/multimedia/${id}/statistics`),
    add: new Route('/user/multimedia/add', HttpRequestMethodEnum.Post),
    update: (id: number) => new Route(`/user/multimedia/${id}/edit`, HttpRequestMethodEnum.Put),
    delete: (id: number) =>
      new Route(`/user/multimedia/${id}/delete`, HttpRequestMethodEnum.Delete),
    like: (id: number) => new Route(`/user/multimedia/${id}/like`, HttpRequestMethodEnum.Patch),
    dislike: (id: number) =>
      new Route(`/user/multimedia/${id}/dislike`, HttpRequestMethodEnum.Patch),
    send_on_moderation: (id: number) =>
      new Route(`/user/multimedia/${id}/send-on-moderation`, HttpRequestMethodEnum.Patch),
    send_on_appeal: (id: number) =>
      new Route(`/user/multimedia/${id}/send-on-appeal`, HttpRequestMethodEnum.Patch),
    add_to_media_library: (id: number) =>
      new Route(`/user/multimedia/${id}/add-to-media-library`, HttpRequestMethodEnum.Post),
    play_pause: (id: number) =>
      new Route(`/user/multimedia/${id}/play-pause`, HttpRequestMethodEnum.Patch),

    time_code: {
      add: (id: number) =>
        new Route(`/user/multimedia/${id}/time-code/add`, HttpRequestMethodEnum.Post),
      delete: (id: number) =>
        new Route(`/user/multimedia/time-code/${id}/delete`, HttpRequestMethodEnum.Delete)
    }
  },

  artist: {
    subscribe: (id: number) => new Route(`/artist/${id}/subscribe`, HttpRequestMethodEnum.Patch),
    unsubscribe: (id: number) => new Route(`/artist/${id}/unsubscribe`, HttpRequestMethodEnum.Patch)
  },

  media_library: {
    all: new Route('/user/media-library/multimedia/all'),
    statistics: new Route('/user/media-library/statistic'),

    multimedia: {
      share: (multimediaId: number, friendId: number) =>
        new Route(
          `/user/media-library/multimedia/${multimediaId}/share/with-friend/${friendId}`,
          HttpRequestMethodEnum.Patch
        ),
      update: (id: number) =>
        new Route(`/user/media-library/multimedia/${id}/edit`, HttpRequestMethodEnum.Put),
      delete: (id: number) =>
        new Route(`/user/media-library/multimedia/${id}/delete`, HttpRequestMethodEnum.Delete),

      event: {
        add: (id: number) =>
          new Route(`/user/media-library/multimedia/${id}/event/add`, HttpRequestMethodEnum.Post),
        update: (id: number) =>
          new Route(`/user/media-library/multimedia/event/${id}/edit`, HttpRequestMethodEnum.Put),
        delete: (id: number) =>
          new Route(
            `/user/media-library/multimedia/event/${id}/delete`,
            HttpRequestMethodEnum.Delete
          )
      }
    },

    event: {
      add: new Route('/user/media-library/event/add', HttpRequestMethodEnum.Post),
      update: (id: number) =>
        new Route(`/user/media-library/event/${id}/edit`, HttpRequestMethodEnum.Put),
      delete: (id: number) =>
        new Route(`/user/media-library/event/${id}/delete`, HttpRequestMethodEnum.Delete)
    }
  },

  playlist: {
    all: new Route(
      '/user/media-library/playlist/all',
      HttpRequestMethodEnum.Get,
      ['title'],
      ['title', 'createdAt', 'numberMultimedia']
    ),
    read: (id: number) => new Route(`/user/media-library/playlist/${id}/read`),
    create: new Route('/user/media-library/playlist/create', HttpRequestMethodEnum.Post),
    update: (id: number) =>
      new Route(`/user/media-library/playlist/${id}/edit`, HttpRequestMethodEnum.Put),
    delete: (id: number) =>
      new Route(`/user/media-library/playlist/${id}/delete`, HttpRequestMethodEnum.Delete),

    multimedia: {
      move_to_directory: (multimediaId: number, directoryId: number) =>
        new Route(
          `/user/media-library/playlist/multimedia/${multimediaId}/move/directory/${directoryId}`,
          HttpRequestMethodEnum.Put
        )
    },

    directory: {
      create: (id: number) =>
        new Route(
          `/user/media-library/playlist/${id}/directory/create`,
          HttpRequestMethodEnum.Post
        ),
      update: (id: number) =>
        new Route(`/user/media-library/playlist/directory/${id}/edit`, HttpRequestMethodEnum.Put),
      delete: (id: number) =>
        new Route(
          `/user/media-library/playlist/directory/${id}/delete`,
          HttpRequestMethodEnum.Delete
        ),

      multimedia: {
        add: (directoryId: number, multimediaId: number) =>
          new Route(
            `/user/media-library/playlist/directory/${directoryId}/multimedia/${multimediaId}/add`,
            HttpRequestMethodEnum.Post
          ),
        delete: (id: number) =>
          new Route(
            `/user/media-library/playlist/directory/multimedia/${id}/delete`,
            HttpRequestMethodEnum.Delete
          )
      }
    }
  },

  user: {
    profile: {
      update_design: new Route('/user/profile/design/edit', HttpRequestMethodEnum.Put)
    }
  },

  friend: {
    all: new Route('/user/friend/all', HttpRequestMethodEnum.Get, [], ['date', 'acceptFriendship']),
    add: (id: number) => new Route(`/user/${id}/add-as-friend`, HttpRequestMethodEnum.Post),
    accept_application: (id: number) =>
      new Route(`/user/friend/${id}/accept`, HttpRequestMethodEnum.Patch),
    delete: (id: number) => new Route(`/user/friend/${id}/delete`, HttpRequestMethodEnum.Delete)
  },

  history: {
    all: new Route('/user/history/all', HttpRequestMethodEnum.Get, ['now'], ['date']),
    delete: (id: number) =>
      new Route(`/user/history/listen/${id}/delete`, HttpRequestMethodEnum.Delete)
  }
};
