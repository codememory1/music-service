import SelectService from '~/services/ui/Select/select-service';
import BaseSelectOption from '~/components/UI/FormElements/Select/BaseSelectOption.vue';
import SelectListService from '~/services/ui/Select/select-list-service';
import SelectOptionService from '~/services/ui/Select/select-option-service';

export default class SelectKeydownService {
  private readonly selectService: SelectService;
  private readonly selectListService: SelectListService;

  public constructor(selectService: SelectService, selectListService: SelectListService) {
    this.selectService = selectService;
    this.selectListService = selectListService;
  }

  public handle(event: KeyboardEvent, asMultiple: boolean): void {
    if (this.selectService.isOpened()) {
      switch (event.key) {
        case 'ArrowDown':
          this.arrowDown(event);
          break;
        case 'ArrowUp':
          this.arrowUp(event);
          break;
        case 'Enter':
          this.enter(asMultiple);
          break;
      }
    }
  }

  private arrowDown(event: KeyboardEvent): void {
    event.preventDefault();

    this.setScrollIntoViewOnOption(this.selectService.activeNextOption());
  }

  private arrowUp(event: KeyboardEvent): void {
    event.preventDefault();

    this.setScrollIntoViewOnOption(this.selectService.activePrevOption());
  }

  private enter(asMultiple: boolean): void {
    this.selectListService.selectActivatedOption(asMultiple);
  }

  private setScrollIntoViewOnOption(option: SelectOptionService): void {
    const options = this.selectService.app.$refs.option as Array<BaseSelectOption>;
    const optionIndex = this.selectService.getOptions().indexOf(option);

    (options[optionIndex].$el as HTMLElement).scrollIntoView({
      behavior: 'smooth',
      block: 'end',
      inline: 'nearest'
    });
  }
}
