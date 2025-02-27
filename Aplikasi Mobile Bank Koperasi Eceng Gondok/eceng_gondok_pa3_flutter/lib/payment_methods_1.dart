import 'package:flutter/material.dart';
import 'payment_methods_2.dart';

class PaymentMethodsScreen extends StatefulWidget {
  @override
  _PaymentMethodsScreenState createState() => _PaymentMethodsScreenState();
}

class _PaymentMethodsScreenState extends State<PaymentMethodsScreen> {
  int? selectedCardIndex;
  List<String> paymentCards = ["Card 1", "Card 2"];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Payment methods"),
        leading: IconButton(
          icon: Icon(Icons.arrow_back),
          onPressed: () => Navigator.pop(context),
        ),
      ),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text("Payment Cards", style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
            SizedBox(height: 16),
            Expanded(
              child: ListView.builder(
                itemCount: paymentCards.length,
                itemBuilder: (context, index) {
                  return Column(
                    children: [
                      Container(
                        height: 120,
                        width: double.infinity,
                        decoration: BoxDecoration(
                          color: Colors.grey[300],
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Center(
                          child: Text(
                            "Cards",
                            style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                          ),
                        ),
                      ),
                      Row(
                        children: [
                          Checkbox(
                            value: selectedCardIndex == index,
                            onChanged: (value) {
                              setState(() {
                                selectedCardIndex = value! ? index : null;
                              });
                            },
                          ),
                          Text("Use as default payment method"),
                        ],
                      ),
                      SizedBox(height: 16),
                    ],
                  );
                },
              ),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => PaymentMethodsScreen2()),
                );
              },
              child: Text("Proceed to Next Step"),
            ),
          ],
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          setState(() {
            paymentCards.add("New Card");
          });
        },
        child: Icon(Icons.add),
      ),
    );
  }
}
