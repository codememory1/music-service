export default function passwordComplexityLevel(password: string): number {
  const hasSmallLetters = password.search(/[a-z]+/) > -1;
  const hasCapitalLetters = password.search(/[A-Z]+/) > -1;
  const hasNumbers = password.search(/[0-9]+/) > -1;
  const specialChars = '<>@!#$%^&*()_+[]{}?:;|"\\,./~`-=';
  const specialCharsToPassword = password.split('').reduce((acc, char) => {
    if (specialChars.includes(char)) {
      ++acc;
    }

    return acc;
  }, 0);

  let percentageLevel: number = 0;

  if (password.length < 8) {
    return 20;
  }

  if (hasSmallLetters) {
    percentageLevel += 20;
  }

  if (hasCapitalLetters) {
    percentageLevel += 20;
  }

  if (hasNumbers) {
    percentageLevel += 20;
  }

  if (specialCharsToPassword >= 1) {
    percentageLevel += 20;
  }

  if (specialCharsToPassword >= 3) {
    percentageLevel += 20;
  }

  return percentageLevel;
}
