import { SelectOptionType } from '~/types/SelectOptionType';

export default class SelectOption {
  public static getOptionByValue(
    value: string,
    options: Array<SelectOptionType>
  ): SelectOptionType | undefined {
    for (let i = 0; i < options.length; i++) {
      if (options[i].value === value) {
        return options[i];
      }
    }

    return undefined;
  }

  public static searchOptionByTitle(
    title: string,
    options: Array<SelectOptionType>
  ): Array<SelectOptionType> {
    const finedOptions: Array<SelectOptionType> = [];

    options.forEach((option: SelectOptionType) => {
      if (option.title.search(new RegExp('^' + title, 'i')) !== -1) {
        finedOptions.push(option);
      }
    });

    return finedOptions;
  }
}
