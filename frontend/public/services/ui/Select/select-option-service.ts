import SelectService from '~/services/ui/Select/select-service';
import SelectOptionType from '~/types/ui/select/select-option-type';

export default class SelectOptionService {
  private readonly selectService: SelectService;
  public readonly option: SelectOptionType;
  private selected: boolean = false;
  private active: boolean = false;

  public constructor(selectService: SelectService, option: SelectOptionType) {
    this.selectService = selectService;
    this.option = option;
  }

  public getOption(): SelectOptionType {
    return this.option;
  }

  public isSelected(): boolean {
    return this.selected;
  }

  public setIsSelected(is: boolean): SelectOptionService {
    this.selected = is;

    return this;
  }

  public isActive(): boolean {
    return this.active;
  }

  public setIsActive(is: boolean): SelectOptionService {
    this.active = is;

    return this;
  }

  public unselect(): SelectOptionService {
    this.setIsSelected(false);

    this.selectService.app.$emit('unselectOption', this.option);
    this.selectService.close();

    return this;
  }
}
