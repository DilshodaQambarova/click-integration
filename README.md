### Full Authentication with SMS Verification

This project implements a complete authentication system where users are required to verify their phone numbers via SMS. If a user has not verified their phone number, they will not be able to log in. Additionally, users who fail to verify their phone number within three days will be automatically removed from the database.

## Key Features:
- SMS Authentication: Users must verify their phone numbers to log in.
- Automatic User Cleanup: Users who have not verified their phone number within 3 days are deleted from the database.
- Verification Code Refresh: The user's verification code is automatically refreshed every minute.

## Design Patterns Implemented:

- Repository Pattern: Used for interacting with the database, promoting a cleaner separation of concerns.
- Service Pattern: Encapsulates business logic.
- DTO (Data Transfer Object): Used for transferring data between layers of the application.

## Advanced Response:

- Custom responses for better API consistency and error handling.
- Proper data formatting with `Resources`.

## Installation and Setup

- Clone the repository:
```
git clone https://sms-from-eskiz.git
cd sms-from-eskiz
```
- Install dependencies:
```
composer install
```
- Set up environment variables: Make sure to configure your .env file for database connection and SMS service.
```
cp .env.example .env
```
```
php artisan key:generate
```
- Run migrations:
```
php artisan migrate

```
- Run the scheduler for verification code updates & clean unverified users: Ensure your scheduler runs every minute to refresh the verification_code:

```
php artisan schedule:run
```
- Start the server:
```

php artisan serve
```
## Api 
- [Api Documentation](https://documenter.getpostman.com/view/39432331/2sAYQdjVkT)
## Usage

- User Registration: When a user registers, they will receive an SMS with a verification code.
- Login: Only users who have verified their phone numbers can log in.
- Automatic Cleanup: Users who have not verified their phone numbers within 3 days will be deleted from the database.

## Commands

- Verification Code Refresh: Every minute, the system updates the verification_code for all users who have not verified their phone number.
- Cleaning users who have not verified their phone within three days





