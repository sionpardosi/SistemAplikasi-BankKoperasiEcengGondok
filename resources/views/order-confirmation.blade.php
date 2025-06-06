@extends('layouts.app')

@section('content')
    <style>
        .cart-total th,
        .cart-total td {
            color: green;
            font-weight: bold;
            font-size: 21px !important;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 60px !important;
        }

        /* Checkout Steps - Modern Design */
        :root {
            --primary: #956a3b;
            --primary-light: rgba(149, 106, 59, 0.12);
            --primary-lighter: rgba(149, 106, 59, 0.06);
            --primary-dark: #7d593a;
            --white: #ffffff;
            --text-dark: #333333;
            --text-medium: #555555;
            --text-light: #767676;
            --border-radius: 16px;
            --shadow-soft: 0 10px 30px rgba(149, 106, 59, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        /* Progress Bar */
        .checkout-steps:before {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: #e7e0d8;
            z-index: -1;
        }

        .checkout-steps:after {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), #a87c4f);
            z-index: -1;
            transition: var(--transition);
        }

        .checkout-steps.step-1:after {
            width: 0%;
        }

        .checkout-steps.step-2:after {
            width: 50%;
        }

        .checkout-steps.step-3:after {
            width: 100%;
        }

        .checkout-steps__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            position: relative;
            width: 33.333%;
            transition: var(--transition);
        }

        /* Step Number */
        .checkout-steps__item-number {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-light);
            background-color: #f0e9e1;
            border: 3px solid #e7e0d8;
            margin-bottom: 16px;
            position: relative;
            transition: var(--transition);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .checkout-steps__item-number:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), #a87c4f);
            opacity: 0;
            transition: var(--transition);
            border-radius: 50%;
            transform: scale(0.8);
        }

        .checkout-steps__item-number span {
            position: relative;
            z-index: 2;
        }

        /* Step Title */
        .checkout-steps__item-title {
            display: flex;
            flex-direction: column;
            gap: 5px;
            transition: var(--transition);
        }

        .checkout-steps__item-title span {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-medium);
            transition: var(--transition);
        }

        .checkout-steps__item-title em {
            font-size: 13px;
            font-style: normal;
            color: var(--text-light);
            transition: var(--transition);
            max-width: 160px;
            margin: 0 auto;
        }

        /* Step Icon */
        .checkout-steps__item-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            color: var(--white);
            font-size: 20px;
            transition: all 0.4s cubic-bezier(0.68, -0.6, 0.32, 1.6);
            z-index: 3;
        }

        /* Active State */
        .checkout-steps__item.active .checkout-steps__item-number {
            border-color: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.25);
        }

        .checkout-steps__item.active .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.active .checkout-steps__item-title span {
            color: var(--primary);
            font-weight: 700;
        }

        .checkout-steps__item.active .checkout-steps__item-title em {
            color: var(--text-medium);
        }

        /* Completed State */
        .checkout-steps__item.completed .checkout-steps__item-number {
            border-color: var(--primary);
            color: rgba(0, 0, 0, 0);
            background-color: var(--primary);
        }

        .checkout-steps__item.completed .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.completed .checkout-steps__item-icon {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Payment Timeout Alert - NEW */
        .payment-timeout-alert {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            position: relative;
            overflow: hidden;
        }

        .payment-timeout-alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .timeout-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .timeout-header i {
            font-size: 24px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .timeout-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .countdown-display {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .timeout-message {
            font-size: 14px;
            text-align: center;
            margin: 0;
            opacity: 0.9;
        }

        /* New Styles for Order Confirmation Page */
        .order-complete {
            max-width: 1200px;
            margin: 0 auto;
        }

        .order-complete__message {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 30px 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.2);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .order-complete__message::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        .success-icon {
            margin-bottom: 20px;
            animation: bounceIn 0.8s ease-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .order-complete__message h3 {
            margin: 0 0 15px 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .order-complete__message p {
            max-width: 500px;
            margin: 0 auto;
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
        }

        /* Quick Order Info - NEW */
        .quick-order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .quick-info-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .quick-info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        .quick-info-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .quick-info-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .quick-info-label {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-info-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 5px;
        }

        /* Badge Styling Fix */
        .badge {
            padding: 8px 12px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .badge.bg-warning {
            background-color: #f39c12 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
        }

        .badge.bg-info {
            background-color: #3498db !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
        }

        .badge.bg-success {
            background-color: #27ae60 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
        }

        .badge.bg-danger {
            background-color: #e74c3c !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }

        .badge.bg-secondary {
            background-color: #7f8c8d !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(127, 140, 141, 0.3);
        }

        .badge.bg-primary {
            background-color: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(149, 106, 59, 0.3);
        }

        /* Enhanced Order Details */
        .order-details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .order-details-container {
                grid-template-columns: 1fr;
            }
        }

        .order-details-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            padding: 30px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .order-details-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
        }

        .order-details-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), #a87c4f);
        }

        .order-details-box h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            position: relative;
            padding-bottom: 15px;
        }

        .order-details-box h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        .order-details-box h4 i {
            margin-right: 12px;
            color: var(--primary);
            font-size: 20px;
        }

        /* Enhanced Address & Shipping Details */
        .address-detail {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
            border: 1px solid #e9ecef;
        }

        .recipient-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recipient-name i {
            color: var(--primary);
        }

        .address-detail p {
            margin-bottom: 10px;
            color: var(--text-medium);
            display: flex;
            align-items: flex-start;
            line-height: 1.6;
        }

        .address-detail p i {
            width: 20px;
            color: var(--primary);
            margin-right: 10px;
            margin-top: 4px;
        }

        .shipping-detail {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .shipping-detail-item {
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 3px solid var(--primary);
            transition: transform 0.2s ease;
        }

        .shipping-detail-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .shipping-detail-item h5 {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .shipping-detail-item h5 i {
            margin-right: 6px;
            font-size: 14px;
            color: var(--primary);
        }

        .shipping-detail-item p {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        /* Enhanced Product Items */
        .order-product-item {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .order-product-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 0 -10px;
            padding: 20px 10px;
        }

        .order-product-item:last-child {
            border-bottom: none;
        }

        .order-product-item__image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 20px;
            background-color: #f7f7f7;
            border: 1px solid #eee;
            position: relative;
        }

        .order-product-item__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .order-product-item:hover .order-product-item__image img {
            transform: scale(1.05);
        }

        .order-product-item__details {
            flex: 1;
        }

        .order-product-item__name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
            line-height: 1.4;
        }

        .order-product-item__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
        }

        .order-product-item__meta-item {
            font-size: 14px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .order-product-item__meta-item i {
            margin-right: 5px;
            font-size: 12px;
            color: var(--primary);
        }

        .order-product-item__price {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            margin-left: auto;
            align-self: flex-start;
        }

        /* Enhanced Order Summary */
        .order-summary {
            margin-top: 30px;
        }

        .order-summary-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-summary-title i {
            color: var(--primary);
        }

        .checkout-totals {
            width: 100%;
        }

        .checkout-totals tr {
            border-bottom: 1px solid #f5f5f5;
        }

        .checkout-totals tr:last-child {
            border-bottom: none;
        }

        .checkout-totals th {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-medium);
            padding: 15px 0;
            text-align: left;
        }

        .checkout-totals td {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            padding: 15px 0;
            text-align: right;
        }

        .checkout-totals .cart-total th,
        .checkout-totals .cart-total td {
            font-size: 20px !important;
            font-weight: 700;
            color: var(--primary);
            padding-top: 25px;
            border-top: 2px solid var(--primary);
        }

        /* Enhanced Payment Button */
        .payment-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--primary), #a87c4f);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 18px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 6px 20px rgba(149, 106, 59, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-pay::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-pay:hover::before {
            left: 100%;
        }

        .btn-pay:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(149, 106, 59, 0.4);
        }

        .btn-pay i {
            font-size: 18px;
        }

        .payment-info {
            padding: 18px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            border-left: 4px solid var(--primary);
            font-size: 14px;
            color: var(--text-medium);
            line-height: 1.6;
            margin-top: 15px;
        }

        .payment-info i {
            color: var(--primary);
            margin-right: 8px;
        }

        /* Order Tracking Feature - NEW */
        .order-tracking {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
        }

        .tracking-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tracking-title i {
            color: var(--primary);
        }

        .tracking-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .tracking-item {
            text-align: center;
            flex: 1;
        }

        .tracking-item i {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .tracking-item span {
            display: block;
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
        }

        /* Quick Actions - NEW */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .quick-action-btn:hover {
            border-color: var(--primary);
            background: var(--primary-lighter);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .quick-action-btn i {
            font-size: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .checkout-steps__item-number {
                width: 60px;
                height: 60px;
                font-size: 18px;
            }

            .checkout-steps__item-title span {
                font-size: 15px;
            }

            .checkout-steps__item-title em {
                font-size: 12px;
            }

            .quick-order-info {
                grid-template-columns: 1fr;
            }

            .shipping-detail {
                grid-template-columns: 1fr;
            }

            .order-product-item {
                flex-direction: column;
            }

            .order-product-item__image {
                margin-right: 0;
                margin-bottom: 15px;
                width: 80px;
                height: 80px;
            }

            .order-product-item__price {
                margin-left: 0;
                margin-top: 10px;
            }

            .countdown-display {
                font-size: 2rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .checkout-steps__item-title em {
                display: none;
            }

            .order-details-box {
                padding: 20px 15px;
            }

            .countdown-display {
                font-size: 1.8rem;
            }
        }

        /* Bank Transfer Styles */
        .bank-transfer-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
        }

        .bank-info-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .bank-info-card h6 {
            color: var(--primary);
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 16px;
        }

        .bank-details p {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .bank-details strong {
            min-width: 120px;
            color: var(--text-dark);
        }

        .upload-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 2px dashed #dee2e6;
            transition: border-color 0.3s ease;
        }

        .upload-section:hover {
            border-color: var(--primary);
        }

        .upload-section .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .upload-section .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
        }

        .upload-section .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        .form-text {
            color: #6c757d;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Payment Sections Styles */
        .bank-transfer-section,
        .midtrans-payment-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
        }

        .bank-info-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .bank-info-card h6 {
            color: var(--primary);
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 16px;
        }

        .bank-details p {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .bank-details strong {
            min-width: 120px;
            color: var(--text-dark);
        }

        .upload-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 2px dashed #dee2e6;
            transition: border-color 0.3s ease;
        }

        .upload-section:hover {
            border-color: var(--primary);
        }

        .upload-section .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .upload-section .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
        }

        .upload-section .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        .form-text {
            color: #6c757d;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">KONFIRMASI PESANAN</h2>

            <!-- Modern Checkout Steps -->
            <div class="checkout-steps step-3">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>01</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Keranjang Belanja</span>
                        <em>Kelola Daftar Barang Anda</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>02</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Pilih Alamat dan Metode</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item active">
                    <div class="checkout-steps__item-number">
                        <span>03</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Konfirmasi</span>
                        <em>Tinjau dan Kirim Pesanan</em>
                    </div>
                </a>
            </div>

            <div class="order-complete">
                <!-- Payment Timeout Alert -->
                @if ($order->transaction && $order->transaction->status === 'pending')
                    <div class="payment-timeout-alert">
                        <div class="timeout-header">
                            <i class="fas fa-clock"></i>
                            <h4 class="timeout-title">Batas Waktu Pembayaran</h4>
                        </div>
                        <div class="countdown-display" id="payment-countdown">23:59:59</div>
                        <p class="timeout-message">Selesaikan pembayaran sebelum waktu habis untuk mengonfirmasi pesanan
                            Anda</p>
                    </div>
                @endif

                <!-- Quick Order Information -->
                <div class="quick-order-info">
                    <div class="quick-info-card">
                        <div class="quick-info-header">
                            <div class="quick-info-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="quick-info-label">Nomor Pesanan</div>
                        </div>
                        <div class="quick-info-value">#{{ $order->id }}</div>
                    </div>

                    <div class="quick-info-card">
                        <div class="quick-info-header">
                            <div class="quick-info-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="quick-info-label">Tanggal Pesanan</div>
                        </div>
                        <div class="quick-info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="quick-info-card">
                        <div class="quick-info-header">
                            <div class="quick-info-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="quick-info-label">Total Pembayaran</div>
                        </div>
                        <div class="quick-info-value">{{ formatRupiah($order->total) }}</div>
                    </div>

                    <div class="quick-info-card">
                        <div class="quick-info-header">
                            <div class="quick-info-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="quick-info-label">Metode Pembayaran</div>
                        </div>
                        <div class="quick-info-value">
                            @if ($order->transaction)
                                {{ $order->transaction->mode_display }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detailed Order Information -->
                <div class="order-details-container">
                    <!-- Shipping Details -->
                    <div class="order-details-box">
                        <h4><i class="fas fa-shipping-fast"></i> INFORMASI PENGIRIMAN</h4>

                        <div class="address-detail">
                            <div class="recipient-name">
                                <i class="fas fa-user"></i>
                                {{ $order->name }}
                            </div>
                            <p><i class="fas fa-map-marker-alt"></i> <span>{{ $order->address }}</span></p>
                            <p><i class="fas fa-road"></i> <span>{{ $order->locality }}</span></p>
                            <p><i class="fas fa-city"></i> <span>{{ $order->city }}, {{ $order->state }},
                                    {{ $order->zip }}</span></p>
                            <p><i class="fas fa-phone"></i> <span>{{ $order->phone }}</span></p>
                            @if ($order->landmark)
                                <p><i class="fas fa-landmark"></i> <span>Patokan: {{ $order->landmark }}</span></p>
                            @endif
                        </div>

                        <h4 style="margin-top: 25px;"><i class="fas fa-truck"></i> DETAIL PENGIRIMAN</h4>

                        <div class="shipping-detail">
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-shipping-fast"></i> Kurir</h5>
                                <p>
                                    @php
                                        $courierNames = [
                                            'jne' => 'JNE',
                                            'pos' => 'POS Indonesia',
                                            'tiki' => 'TIKI',
                                        ];
                                        $courierName = isset($courierNames[$order->kurir])
                                            ? $courierNames[$order->kurir]
                                            : strtoupper($order->kurir);
                                    @endphp
                                    {{ $courierName }}
                                </p>
                            </div>
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-money-bill-wave"></i> Ongkos Kirim</h5>
                                <p>{{ formatRupiah($order->ongkir) }}</p>
                            </div>
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-box"></i> Status Pesanan</h5>
                                <p>{!! $order->status_badge !!}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-details-box">
                        <h4><i class="fas fa-clipboard-list"></i> RINGKASAN PESANAN</h4>

                        <!-- Product Items -->
                        <div class="order-products">
                            @foreach ($order->orderItems as $item)
                                <div class="order-product-item">
                                    <div class="order-product-item__image">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}">
                                        @else
                                            <div
                                                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0f0f0;">
                                                <i class="fas fa-image" style="font-size:24px;color:#ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="order-product-item__details">
                                        <span class="order-product-item__name">{{ $item->product->name }}</span>
                                        <div class="order-product-item__meta">
                                            <span class="order-product-item__meta-item">
                                                <i class="fas fa-box"></i> Qty: {{ $item->quantity }}
                                            </span>

                                            @if ($item->options)
                                                @php
                                                    if (is_string($item->options)) {
                                                        $options = json_decode($item->options, true);
                                                    } else {
                                                        $options = $item->options;
                                                    }
                                                @endphp
                                                @if (isset($options['size_name']))
                                                    <span class="order-product-item__meta-item">
                                                        <i class="fas fa-ruler-combined"></i> {{ $options['size_name'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="order-product-item__price">
                                        {{ formatRupiah($item->price) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-summary">
                            <div class="order-summary-title">
                                <i class="fas fa-calculator"></i>
                                TOTAL PEMBAYARAN
                            </div>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal Produk</th>
                                        <td>{{ formatRupiah($order->subtotal) }}</td>
                                    </tr>
                                    @if ($order->discount > 0)
                                        <tr>
                                            <th>Diskon</th>
                                            <td>-{{ formatRupiah($order->discount) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        <td>{{ formatRupiah($order->ongkir) }}</td>
                                    </tr>
                                    <tr class="cart-total">
                                        <th>TOTAL</th>
                                        <td>{{ formatRupiah($order->total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Payment Button -->
                        <div class="payment-actions">
                            @if ($order->transaction && $order->transaction->status === 'pending')
                                {{-- Cek apakah ada snap_token (Midtrans) --}}
                                @if ($order->transaction->snap_token)
                                    <!-- Midtrans Payment -->
                                    <button id="pay-button" class="btn-pay">
                                        <i class="fas fa-credit-card"></i> BAYAR SEKARANG
                                    </button>

                                    <div class="payment-info" style="margin-top: 15px;">
                                        <i class="fas fa-shield-alt"></i> Pembayaran dilindungi dengan enkripsi SSL dan
                                        berbagai metode pembayaran tersedia.
                                    </div>
                                    {{-- Cek apakah ini pembayaran manual transfer --}}
                                @elseif ($order->transaction->mode === 'manual_atm' || $order->transaction->bank_code)
                                    <!-- Manual Bank Transfer -->
                                    <div class="bank-transfer-section">
                                        <h4 style="color: var(--primary); margin-bottom: 20px;">
                                            <i class="fas fa-university"></i> Pembayaran Transfer Bank BNI
                                        </h4>

                                        <!-- Bank Account Info -->
                                        <div class="bank-info-card mb-4">
                                            <h6><i class="fa fa-university me-1"></i> Informasi Rekening Bank BNI</h6>
                                            <div class="bank-details">
                                                <p><strong>Bank:</strong> Bank BNI</p>
                                                <p><strong>No. Rekening:</strong> 1234567890</p>
                                                <p><strong>Atas Nama:</strong> Bank Koperasi Eceng Gondok</p>
                                                <p><strong>Jumlah Transfer:</strong> <span
                                                        class="text-danger fw-bold">{{ formatRupiah($order->total) }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Upload Payment Proof Form -->
                                        <div class="upload-section">
                                            <form action="{{ route('upload.payment.proof') }}" method="POST"
                                                enctype="multipart/form-data" id="upload-payment-form">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                                <div class="mb-3">
                                                    <label for="payment_proof" class="form-label">
                                                        <i class="fa fa-upload me-1"></i> Upload Bukti Pembayaran
                                                    </label>
                                                    <input type="file" class="form-control" id="payment_proof"
                                                        name="payment_proof" accept="image/*,.pdf" required>
                                                    <div class="form-text">
                                                        Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn-pay"
                                                    style="background: linear-gradient(135deg, #28a745, #20c997);">
                                                    <i class="fa fa-upload me-2"></i> UPLOAD BUKTI PEMBAYARAN
                                                </button>
                                            </form>
                                        </div>

                                        <div class="payment-info" style="margin-top: 20px;">
                                            <i class="fas fa-info-circle"></i> Setelah upload bukti pembayaran, pesanan
                                            Anda akan diverifikasi oleh admin dalam 1x24 jam.
                                        </div>
                                    </div>
                                    {{-- Fallback jika mode tidak dikenali --}}
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Mode pembayaran tidak dikenali. Silakan hubungi customer service.
                                    </div>
                                    <a href="{{ route('home.contact.index') }}" class="btn-pay"
                                        style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                                        <i class="fas fa-phone"></i> HUBUNGI CUSTOMER SERVICE
                                    </a>
                                @endif
                            @else
                                {{-- Jika status bukan pending --}}
                                <a href="{{ route('user.account.orders') }}" class="btn-pay">
                                    <i class="fas fa-user"></i> LIHAT PESANAN SAYA
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('user.account.orders') }}" class="quick-action-btn">
                        <i class="fas fa-list"></i>
                        <span>Lihat Semua Pesanan</span>
                    </a>
                    {{-- <a href="#" class="quick-action-btn" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        <span>Cetak Invoice</span>
                    </a> --}}
                    <a href="{{ route('home.contact.index') }}" class="quick-action-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($order->transaction && $order->transaction->snap_token && $order->transaction->status === 'pending')
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Midtrans Script -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');
                if (payButton) {
                    payButton.addEventListener('click', function() {
                        snap.pay('{{ $order->transaction->snap_token }}', {
                            onSuccess: function(result) {
                                console.log("Success", result);

                                // Tampilkan loading state
                                Swal.fire({
                                    title: 'Memproses Pembayaran...',
                                    text: 'Sedang memverifikasi pembayaran Anda. Mohon tunggu.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Auto-check status dengan polling
                                checkPaymentStatus();
                            },
                            onPending: function(result) {
                                console.log("Pending", result);
                                Swal.fire({
                                    title: 'Pembayaran Sedang Diproses',
                                    text: 'Pembayaran Anda sedang dalam proses verifikasi.',
                                    icon: 'info',
                                    iconColor: '#b9a16b',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#b9a16b',
                                }).then(() => {
                                    // Check status juga untuk pending
                                    checkPaymentStatus();
                                });
                            },
                            onError: function(result) {
                                console.log("Error", result);
                                Swal.fire({
                                    title: 'Pembayaran Gagal',
                                    text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                                    icon: 'error',
                                    iconColor: '#e74c3c',
                                    confirmButtonText: 'Coba Lagi',
                                    confirmButtonColor: '#e74c3c',
                                });
                            },
                            onClose: function() {
                                Swal.fire({
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda menutup jendela pembayaran. Anda dapat mencoba lagi kapan saja.',
                                    icon: 'warning',
                                    iconColor: '#f39c12',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#f39c12',
                                });
                            }
                        });
                    });
                }

                // Function untuk check payment status
                function checkPaymentStatus() {
                    let attempts = 0;
                    const maxAttempts = 20; // 20 attempts = 2 menit

                    const checkInterval = setInterval(() => {
                        attempts++;

                        // Call ke server untuk refresh status dari Midtrans API
                        fetch('{{ route('auto.check.payment.status') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    transaction_id: {{ $order->transaction->id }}
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Payment check result:', data);

                                if (data.status === 'approved' || data.status === 'paid') {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Pembayaran Berhasil!',
                                        text: 'Terima kasih! Pembayaran Anda telah dikonfirmasi.',
                                        icon: 'success',
                                        iconColor: '#28a745',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#28a745',
                                    }).then(() => {
                                        // Redirect ke halaman order details dengan order ID
                                        window.location.href =
                                            '{{ route('user.account.order.details', ['order_id' => $order->id]) }}';
                                    });

                                } else if (attempts >= maxAttempts) {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Verifikasi Manual Diperlukan',
                                        text: 'Pembayaran mungkin sudah berhasil. Silakan refresh halaman atau klik tombol "Refresh Status Manual".',
                                        icon: 'warning',
                                        iconColor: '#f39c12',
                                        confirmButtonText: 'Refresh Halaman',
                                        confirmButtonColor: '#f39c12',
                                        showCancelButton: true,
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error checking payment status:', error);
                                if (attempts >= maxAttempts) {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Tidak Dapat Memverifikasi',
                                        text: 'Silakan refresh halaman untuk melihat status terbaru.',
                                        icon: 'warning',
                                        confirmButtonText: 'Refresh Halaman',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                    }, 6000); // Check every 6 seconds
                }
            });
        </script>
    @endif

    <script>
        // Enhanced Payment Countdown Timer
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElement = document.getElementById('payment-countdown');
            if (countdownElement) {
                const createdAt = new Date('{{ $order->created_at }}');
                const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 jam dari created_at

                function updateCountdown() {
                    const now = new Date();
                    const timeLeft = deadline - now;

                    if (timeLeft <= 0) {
                        countdownElement.textContent = '00:00:00';
                        const alertBox = document.querySelector('.payment-timeout-alert');
                        if (alertBox) {
                            alertBox.style.background = 'linear-gradient(135deg, #e74c3c, #c0392b)';
                            alertBox.querySelector('.timeout-message').textContent =
                                'Waktu pembayaran telah berakhir';
                        }
                        return;
                    }

                    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdownElement.textContent =
                        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    // Change color when less than 1 hour
                    if (timeLeft < 3600000) { // 1 hour in milliseconds
                        const alertBox = document.querySelector('.payment-timeout-alert');
                        if (alertBox) {
                            alertBox.style.background = 'linear-gradient(135deg, #e67e22, #d35400)';
                        }
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            // Update checkout step
            updateCheckoutStep(3);

            function updateCheckoutStep(step) {
                const checkoutSteps = document.querySelector('.checkout-steps');
                const stepItems = document.querySelectorAll('.checkout-steps__item');

                checkoutSteps.className = 'checkout-steps';
                checkoutSteps.classList.add(`step-${step}`);

                stepItems.forEach((item, index) => {
                    item.classList.remove('active', 'completed');

                    if (index + 1 < step) {
                        item.classList.add('completed');
                    } else if (index + 1 === step) {
                        item.classList.add('active');
                    }
                });
            }
        });
    </script>

    <!-- Functionality for Upload Payment Proof -->
    @if ($order->transaction && $order->transaction->status === 'pending' && !$order->transaction->snap_token)
        <script>
            // Script untuk Upload Bukti Pembayaran
            document.addEventListener('DOMContentLoaded', function() {
                const uploadForm = document.getElementById('upload-payment-form');
                if (uploadForm) {
                    uploadForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const fileInput = document.getElementById('payment_proof');
                        const file = fileInput.files[0];

                        if (!file) {
                            Swal.fire({
                                title: 'File Tidak Dipilih',
                                text: 'Silakan pilih file bukti pembayaran terlebih dahulu.',
                                icon: 'warning',
                                iconColor: '#f39c12',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#f39c12'
                            });
                            return;
                        }

                        // Validasi ukuran file (2MB = 2048KB)
                        if (file.size > 2048 * 1024) {
                            Swal.fire({
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 2MB. Silakan pilih file yang lebih kecil.',
                                icon: 'error',
                                iconColor: '#e74c3c',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#e74c3c'
                            });
                            return;
                        }

                        // Validasi tipe file
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                        if (!allowedTypes.includes(file.type)) {
                            Swal.fire({
                                title: 'Format File Tidak Valid',
                                text: 'Hanya file JPG, PNG, dan PDF yang diperbolehkan.',
                                icon: 'error',
                                iconColor: '#e74c3c',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#e74c3c'
                            });
                            return;
                        }

                        // Tampilkan loading
                        Swal.fire({
                            title: 'Mengupload Bukti Pembayaran...',
                            text: 'Mohon tunggu, sedang memproses upload Anda.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        const formData = new FormData(uploadForm);

                        fetch(uploadForm.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.close();

                                if (data.success) {
                                    Swal.fire({
                                        title: 'Upload Berhasil!',
                                        text: 'Bukti pembayaran Anda telah berhasil diupload. Pesanan akan segera diverifikasi oleh admin.',
                                        icon: 'success',
                                        iconColor: '#28a745',
                                        confirmButtonText: 'Lihat Detail Pesanan',
                                        confirmButtonColor: '#28a745',
                                    }).then(() => {
                                        // Redirect ke halaman order details
                                        window.location.href =
                                            '{{ route('user.account.order.details', ['order_id' => $order->id]) }}';
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Upload Gagal',
                                        text: data.message ||
                                            'Terjadi kesalahan saat mengupload file.',
                                        icon: 'error',
                                        iconColor: '#e74c3c',
                                        confirmButtonText: 'Coba Lagi',
                                        confirmButtonColor: '#e74c3c'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.close();
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Terjadi Kesalahan',
                                    text: 'Gagal mengupload bukti pembayaran. Silakan coba lagi.',
                                    icon: 'error',
                                    iconColor: '#e74c3c',
                                    confirmButtonText: 'Coba Lagi',
                                    confirmButtonColor: '#e74c3c'
                                });
                            });
                    });
                }
            });
        </script>
    @endif

@endsection
