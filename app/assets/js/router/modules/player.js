import PlayerLayout from "../../layouts/PlayerLayout";
import ArtistView from "../../services/Player/ArtistView";

export const routes = [
  {
    path: "/web-player/",
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
