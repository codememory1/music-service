import PlayerLayout from "../layouts/PlayerLayout";
import ArtistView from "../views/player/ArtistView";

export const routes = [
  {
    path: "/",
    component: PlayerLayout,
    name: "playerLayout",
    children: [
      {
        path: "artist/:id",
        component: ArtistView,
        name: "artist"
      }
    ]
  }
];
