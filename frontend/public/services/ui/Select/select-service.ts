import { Vue } from 'vue-property-decorator';
import SelectOptionService from '~/services/ui/Select/select-option-service';

export default class SelectService {
  public readonly app: Vue;
  private opened: boolean = false;
  private options: Array<SelectOptionService>;

  public constructor(app: Vue, options: Array<SelectOptionService>) {
    this.app = app;
    this.options = options;
  }

  public setIsOpened(is: boolean): SelectService {
    this.opened = is;

    return this;
  }

  public isOpened(): boolean {
    return this.opened;
  }

  public getOptions(): Array<SelectOptionService> {
    return this.options;
  }

  public setOptions(options: Array<SelectOptionService>): SelectService {
    this.options = options;

    return this;
  }

  public getOnlySelectedOptions(): Array<SelectOptionService> {
    return this.options.filter((option) => {
      return option.isSelected();
    });
  }

  public getSelectedOption(): SelectOptionService | undefined {
    const selectedOption = this.options.filter((option) => {
      return option.isSelected();
    });

    return selectedOption.length > 0 ? selectedOption[0] : undefined;
  }

  public getActivatedOption(): SelectOptionService | undefined {
    let activatedOption;

    this.options.forEach((option) => {
      if (option.isActive()) {
        activatedOption = option;
      }
    });

    return activatedOption;
  }

  public addOption(option: SelectOptionService): SelectService {
    this.options.push(option);

    return this;
  }

  public open(): void {
    this.setIsOpened(true);

    this.app.$emit('open');
  }

  public close(): void {
    this.setIsOpened(false);

    this.options.forEach((option) => {
      option.setIsActive(false);
    });

    this.app.$emit('close');
  }

  public toggleIsOpened(): SelectService {
    this.opened ? this.close() : this.open();

    return this;
  }

  public search(title: string): SelectService {
    const finedOptions: Array<SelectOptionService> = [];

    this.options.forEach((option: SelectOptionService) => {
      if (option.option.title.search(new RegExp('^' + title, 'i')) !== -1) {
        finedOptions.push(option);
      }
    });

    this.options = finedOptions;

    return this;
  }

  public activeNextOption(): SelectOptionService {
    return this.options
      .next(
        (option) => option.isActive(),
        (option) => {
          option.setIsActive(false);
        }
      )
      .setIsActive(true);
  }

  public activePrevOption(): SelectOptionService {
    return this.options
      .prev(
        (option) => option.isActive(),
        (option) => {
          option.setIsActive(false);
        }
      )
      .setIsActive(true);
  }
}
