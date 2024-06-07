
# BatteryBazaar

BatteryBazaar is a web-based application for managing and purchasing car batteries. The project includes functionalities for user registration, product management, cart management, and order processing.

## Features

- User registration and login
- Product browsing and searching
- Add to cart functionality
- Cart management and checkout
- Admin dashboard for managing products and orders

## Installation

1. Clone the repository:

```bash
git clone <repository_url>
```

2. Navigate to the project directory:

```bash
cd BatteryBazaar
```

3. Set up the database:

   - Import the provided SQL file into your MySQL database.
   - Update the database configuration in `config/db.php` with your database credentials.

4. Start the web server (e.g., XAMPP, WAMP, MAMP).

5. Open the application in your browser:

```bash
http://localhost/BatteryBazaar
```

## File Structure

- `index.php`: Home page of the application.
- `login.php`: User login page.
- `signup.php`: User registration page.
- `shop.php`: Product listing page.
- `product_detail.php`: Product detail page.
- `cart.php`: Shopping cart page.
- `checkout.php`: Checkout page.
- `order_success.php`: Order success page.
- `admin/`: Admin dashboard and management pages.
- `config/`: Database configuration files.
- `css/`: Stylesheets.
- `js/`: JavaScript files.
- `img/`: Images and icons.

## Database Structure

- `Users`: Stores user information.
- `Products`: Stores product information.
- `Categories`: Stores product categories.
- `Orders`: Stores order information.
- `OrderDetails`: Stores details of each order.
- `Cart`: Stores temporary cart information.

## Contribution

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Create a new Pull Request.

## License

This project is licensed under the MIT License.
