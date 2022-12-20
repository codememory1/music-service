import { ContextMenuItemType } from '~/types/ContextMenuItemType';

export type ContextMenuType = {
  id: string;
  items: Array<ContextMenuItemType> | [];
};
