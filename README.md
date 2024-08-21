#Online Banking System

##Description:
Welcome to my Online Banking System project! This web-based application that provides users with a secure and realistic banking experience, allowing them to create accounts, manage their finances, and take out loans with customized payment plans. The system is built with PHP for server-side logic, HTML/CSS for the frontend, and JavaScript for client-side interactivity. The database is managed using MySQL, configured through Laragon, ensuring that all user data is securely stored and easily accessible.

## Project Structure
The project consists of the following key files and directories:

- index.php:
- The homepage of the online banking system where users can log in, view their accounts, and navigate to different sections of the site.

- login.php:
- Handles user authentication, ensuring that only registered users with the correct credentials can access their accounts.

- register.php:
- Allows new users to create an account by providing their personal details and setting up login credentials.

- creareRata.php:
- Facilitates the creation of new loans (rates) by users, including the selection of loan types, setting loan amounts, and defining repayment terms.

- cont.php:
- Displays account details for logged-in users, including balance, transaction history, and other relevant information.

- rate.php:
- Lists all the loans (rates) associated with the user's account, showing their status, remaining balance, and other details.

- tranzactii.php:
- Manages and displays all transactions performed by the user, including deposits, withdrawals, and transfers.

- logout.php:
- Ends the user's session securely, ensuring that their account is protected after logging out.

## Database Structure:
The system's database is built with MySQL and includes the following key tables:

- clienti: Stores user information, including personal details and login credentials.
- conturi: Manages user accounts, tracking balances and other financial details.
- rate: Handles loan information, including loan type, amount, terms, and payment status.
- tranzactii: Logs all transactions made by users, ensuring a complete history of account activity.
  
## Key Features:
- User Registration & Authentication
- Users can securely register and log in to their accounts.
- The system verifies user credentials and grants access only to authorized users.
- Account Management
- Users can view their account details, including balance, transaction history, and other financial information.
- Loan Creation & Management
- Users can create new loans by specifying the loan type, amount, and repayment terms.
- The system ensures that loans are only created for accounts owned by the user.
- Transaction History
- Users can view a complete history of their transactions, including deposits, withdrawals, and transfers.
- Security
- The system includes multiple layers of security, such as session management and input validation, to protect user data.

## Design Choices:
- PHP & MySQL
- PHP was chosen for its robust capabilities in handling server-side logic, while MySQL provides a reliable database solution for storing and managing user data. 

- HTML/CSS & JavaScript
- HTML and CSS were used to create user-friendly interface, while JavaScript adds interactivity and improves the overall user experience.

- Laragon
- Laragon was used to set up a local development environment, making it easier to manage the MySQL database and test the application during development.

## Conclusions:
In conclusion, I successfully developed a realistic and secure online banking system that provides users with essential banking functionalities such as account management, loan creation, and transaction tracking.
