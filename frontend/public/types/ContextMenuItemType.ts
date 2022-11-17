import { ContextMenuType } from '~/types/ContextMenuType';

export type ContextMenuItemType = {
  id: string;
  label: string;
  link?: string;
  disabled: boolean;
  context_menu?: ContextMenuType;
  border: boolean;
};
