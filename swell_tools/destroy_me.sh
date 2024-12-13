echo "This script will delete this whole project folder. \n You must be in the ./swell_tools folder in order to run this script. \n Are you absolutely sure you wanna continue with this? (y or yes to continue)"
read sure
if [ "$sure" == 'y' ] || [ "$sure" == 'yes' ]; then
  env_file="../site/.env"

  if [ -f "$env_file" ]; then
    # Get the value of DB_NAME from the .env file
    db_name=$(grep -E "^DB_NAME=" "$env_file" | cut -d '=' -f 2 | tr -d "[:space:]" | tr -d "'")
    if [ $? -ne 0 ]; then
      echo "Error: Failed to extract DB_NAME from the .env file."
      exit 1
    else
      # Connect to MySQL and delete
      echo "dropping $db_name database"
      mysql -u root -e "DROP DATABASE $db_name;"
      echo "unlinking $db_name"
      valet unlink $db_name

      root_dir=$(dirname "$(pwd)")
      echo "removing $root_dir folder"
      cd ../../ && rm -rf $root_dir
    fi
  else
    echo "Error: you should try this again from the swell_tools/ folder"
    exit 1
  fi
else 
  echo "closing down the script"
  exit 1
fi