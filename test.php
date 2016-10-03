<?php
    class A {
        public static function x()
        {
            return new self();
        }

        public static function y()
        {
            return new static();
        }
    }

    class B extends A { }

    echo get_class(B::x());
    echo get_class(B::y());
    echo get_class(A::x());
    echo get_class(A::y());
