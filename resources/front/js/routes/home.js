import IndexView from "../views/home/IndexView";
import TestView from "../views/home/TestView";

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
