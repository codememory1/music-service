export default function passwordComplexityLevel(password: string): number {
  const hasSmallLetters = password.search(/[a-z]+/);
  const hasCapitalLetters = password.search(/[A-Z]+/);
  const hasNumbers = password.search(/[0-9]+/);
  const hasMinimalSpecialChars = password.search('[\\-\\_\\%\\@\\.\\&\\+]{1,}');
  const hasMoreMinimalSpecialChars = password.search('[\\-\\_\\%\\@\\.\\&\\+]{3,}');

  if (
    hasSmallLetters > -1 &&
    hasCapitalLetters > -1 &&
    hasNumbers > -1 &&
    hasMoreMinimalSpecialChars > -1
  ) {
    return 100;
  }

  if (
    hasSmallLetters > -1 &&
    hasCapitalLetters > -1 &&
    hasNumbers > -1 &&
    hasMinimalSpecialChars > -1
  ) {
    return 80;
  }

  if (hasSmallLetters > -1 && hasCapitalLetters > -1 && hasNumbers > -1) {
    return 60;
  }

  if (hasSmallLetters > -1 && hasCapitalLetters > -1) {
    return 40;
  }

  if (hasSmallLetters > -1) {
    return 20;
  }

  return 0;
}
