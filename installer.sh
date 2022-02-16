#!/bin/bash

function join {
  local IFS="$1";
  shift;

  echo "$*";
}

# Определить окружение
function environment (){
  available=("dev" "prod");
  fined=false;

  echo -n -e "\e[32mВыбирите окружение(\e[1;33m$(join , ${available[@]})\e[0m): \e[0m";
  read selected_env;

  # Проверить существование окружения
  for env in ${available[@]}; do
    if [[ "$env" == "$selected_env" ]]; then
      fined=true;
      break;
    fi
  done

  # Определить корректнсоть выбранного окружения
  if [[ "$fined" == false ]]; then
    echo -e "\tError: Некорректное окружение\n";
    environment;
  else
    echo -e "\e[36m\n[OK] Выбранно окружение=${selected_env}\n\e[0m"
  fi
}
environment;

# Настройка MYSQL
function mysqlSettings (){
  username="";
  password="";
  dbname="";

  echo -n -e "\n
╔―――――――――――――――――――――――――╗
|     Настройка MYSQL     │
╚―――――――――――――――――――――――――╝
\n";

  # Вопрос о имени пользователя
  mysqlUser (){
      echo -n -e "\e[32mУкажите имя пользователя: \e[0m";
      read username;

      if [[ -z $username ]]; then
        echo -e "\tError: Укажите имя пользователя\n";
        mysqlUser;
      fi
  }
  mysqlUser;

  # Вопрос о пароле пользователя
  mysqlPassword (){
    echo -n -e "\e[32mУкажите пароль пользователя: \e[0m";
    read password;

    if [[ -z $password ]]; then
      echo -e "\tError: Укажите пароль пользователя\n";
      mysqlPassword;
    fi
  }
  mysqlPassword;

  # Вопрос о имени базы данных
  mysqlDbname (){
    echo -n -e "\e[32mУкажите имя базы данных: \e[0m";
    read dbname;

    if [[ -z $dbname ]]; then
      echo -e "\tError: Укажите имя базы данных\n";
      mysqlDbname;
    fi
  }
  mysqlDbname;

  echo -e "\e[36m\n[OK] Настройка MYSQL завершена\n\e[0m"

  echo -e "
Созданная вами конфигурация MYSQL:

  - \e[1;33mMYSQL_USER\e[0m     ${username}
  - \e[1;33mMYSQL_PASSWORD\e[0m ${password}
  - \e[1;33mMYSQL_DBNAME\e[0m   ${dbname}
  ";
}
mysqlSettings



