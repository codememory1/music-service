import IndexView from "../../services/Main/IndexView";
import TestView from "../../services/Main/TestVIew";

export const routes = [
  {
    path: "/",
    component: IndexView
  },
  {
    path: "/test",
    component: TestView
  }
];
