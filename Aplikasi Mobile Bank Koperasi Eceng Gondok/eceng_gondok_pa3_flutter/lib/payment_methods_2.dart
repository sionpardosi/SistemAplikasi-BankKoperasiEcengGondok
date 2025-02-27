import 'package:flutter/material.dart';

class PaymentMethodsScreen2 extends StatefulWidget {
  @override
  _PaymentMethodsScreen2State createState() => _PaymentMethodsScreen2State();
}

class _PaymentMethodsScreen2State extends State<PaymentMethodsScreen2> {
  int? selectedCardIndex;
  List<String> paymentCards = ["Card 1", "Card 2", "Card 3", "Card 4"];
