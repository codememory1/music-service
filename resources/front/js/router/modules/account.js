import AccountLayout from "../../layouts/AccountLayout";
import GeneralSettingsView from "../../services/Account/GeneralSettingsView";
import SecurityView from "../../services/Account/SecurityView";
import LanguagesView from "../../services/Account/LanguagesView";
import NotificationsView from "../../services/Account/NotificationsView";
import ConnectedAppsView from "../../services/Account/ConnectedAppsView";

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
