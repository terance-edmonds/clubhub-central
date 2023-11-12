# ClubHub Central

ClubHub Central web application. Build with `PHP` with `MVC` architecture model.

## Naming Conventions

| Type     	| Convention  	| Example     	|
|----------	|-------------	|-------------	|
| File     	| Kebab Case  	| my-file.php 	|
| Class    	| Pascal Case 	| MyFile      	|
| Functions | Camal Case 	| myFunction    |
| Variable 	| Snake Case  	| my_variable 	|

## Extensions Used

To enable extension go to `xampp/php/php.ini` (open via notepad) and remove `;` from the start of the required extension line.

```ini
;extension=gd # when extension is disabled
extension=gd # when extension is enabled
```

* extension=gd

## Usage

1. Clone the repository to `xampp/htdocs/chc` with the below code.
```bash
git clone https://github.com/terance-edmonds/clubhub-central.git
```
2. Install dependencies.
```bash 
composer install
```

3. Setup `.env` file (check `.env.sample`)
   
4. Open `XAMPP` and run `Apache` and `MySql`.

5. Visit `http://localhost/chc/public/home`.

## Development

**Do Not Push to the `master` branch at once.**

1. Create a new branch for development

```bash
git checkout -b dev/{{yourname}}
```

2. Stage the files

```bash
git add .
```

3. Commit the files

```bash
git commit -m "{{message}}"
```

4. Push the update

```bash
git push origin dev/{{yourname}}
```

# Resources

### Icons

```http
https://fonts.google.com/icons?selected=Material+Icons
```