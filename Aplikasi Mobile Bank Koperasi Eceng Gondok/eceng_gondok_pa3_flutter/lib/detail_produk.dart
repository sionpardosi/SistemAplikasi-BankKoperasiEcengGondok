import 'package:flutter/material.dart';

class ProductDetailScreen extends StatelessWidget {
  final Function(String) addToCart;

  ProductDetailScreen({required this.addToCart});

  @override
  Widget build(BuildContext context) {
    return Scaffold(