import passwordComplexityLevel from '~/utils/password-complexity-level';

export default class PasswordLevelService {
  public readonly levels: Array<Array<string>> = [
    ['', '', '', '', ''],
    ['first-level', '', '', '', ''],
    ['first-level', 'second-level', '', '', ''],
    ['first-level', 'second-level', 'third-level', '', ''],
    ['first-level', 'second-level', 'third-level', 'fourth-level', ''],
    ['first-level', 'second-level', 'third-level', 'fourth-level', 'fifth-level']
  ];

  public defineLevel(password: string): Array<string> {
    if (password.length === 0) {
      return this.levels[0];
    }

    switch (passwordComplexityLevel(password)) {
      case 20:
        return this.levels[1];
      case 40:
        return this.levels[2];
      case 60:
        return this.levels[3];
      case 80:
        return this.levels[4];
      default:
        return this.levels[5];
    }
  }
}
