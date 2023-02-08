import SelectService from '~/services/ui/Select/select-service';
import SelectOptionService from '~/services/ui/Select/select-option-service';

export default class SelectListService {
  private readonly selectService: SelectService;

  public constructor(selectService: SelectService) {
    this.selectService = selectService;
  }

  public selectOption(
    selectableOptionService: SelectOptionService,
    asMultiple: boolean
  ): SelectListService {
    if (selectableOptionService.isSelected()) {
      selectableOptionService.unselect();

      return this;
    }

    if (!asMultiple) {
      this.selectService.getOptions().forEach((optionService) => {
        optionService.setIsSelected(false);
      });

      selectableOptionService.setIsSelected(true);

      this.selectService.toggleIsOpened();
    } else {
      selectableOptionService.setIsSelected(true);
    }

    this.selectService.app.$emit('optionSelected', selectableOptionService);

    return this;
  }

  public selectActivatedOption(asMultiple: boolean): void {
    const activatedOption = this.selectService.getActivatedOption();

    if (undefined !== activatedOption) {
      this.selectOption(activatedOption, asMultiple);
    }
  }
}
