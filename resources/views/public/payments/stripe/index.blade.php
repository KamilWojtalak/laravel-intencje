<x-public-layout>

    <section class="public-section">
        <div class="container">
            <h2>Test stripe chekcout page</h2>

            <div class="product">
                <img src="https://i.imgur.com/EHyR2nP.png" alt="The cover of Stubborn Attachments" />
                <div class="description">
                    <h3>Nazwa produktu</h3>
                    <h5>cena: $2.00</h5>
                </div>
            </div>

            <form action="{{ route('payments.stripe.store') }}" method="POST">
                @csrf
                <button type="submit" id="checkout-button">Checkout</button>
            </form>
        </div>
    </section>

</x-public-layout>
