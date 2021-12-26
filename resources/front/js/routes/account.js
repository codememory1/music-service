import AccountLayout from "../layouts/AccountLayout";
import GeneralSettingsView from "../views/account/GeneralSettingsView";
import SecurityView from "../views/account/SecurityView";
import LanguagesView from "../views/account/LanguagesView";
import NotificationsView from "../views/account/NotificationsView";
import ConnectedAppsView from "../views/account/ConnectedAppsView";

export const routes = [
  {
    path: "/",
    component: AccountLayout,
    name: "playerLayout",
    children: [
      {
        path: "general-settings",
        component: GeneralSettingsView,
        name: "general-settings"
      },
      {
        path: "security",
        component: SecurityView,
        name: "security"
      },
      {
        path: "languages",
        component: LanguagesView,
        name: "languages"
      },
      {
        path: "notifications",
        component: NotificationsView,
        name: "notifications"
      },
      {
        path: "connected-apps",
        component: ConnectedAppsView,
        name: "connected-apps"
      }
    ]
  }
];
